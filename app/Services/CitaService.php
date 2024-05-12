<?php

namespace App\Services;

use App\Models\Citas\CitaCita;

class CitaService
{
    public function obtenerCitaAleatoria()
    {
        $cita = CitaCita::with('autor', 'fuente')->inRandomOrder()->first();
        if (!$cita) {
            return null;
        }

        return $this->formatearCitaComoTexto($cita);
    }

    public function obtenerCitaAleatoriaParaWeb()
    {
        $cita = CitaCita::with('autor', 'fuente')->inRandomOrder()->first();
        if (!$cita) {
            return null;
        }

        return $this->formatearCitaComoHTML($cita);
    }

    protected function formatearCitaComoHTML($cita)
    {
        $textoRespuesta = "<h5 class='p-1' style='text-align:center; background-color:darkorange; color:white;'>{$cita->titulo}</h5>";
        $textoRespuesta .= "<div class='text-small p-1 border' style='font-size:10pt'>" . nl2br("{$cita->texto}") . "</div>";
        $textoRespuesta .= '<div class="text-small border p-1" style="font-size:10pt; background-color:ivory">' . $this->armarReferencia($cita) . '</div>';

        return $textoRespuesta;
    }

    protected function formatearCitaComoTexto($cita)
    {
        $textoRespuesta = "*{$cita->titulo}*\n\n";
        $textoRespuesta .= "<< {$cita->texto} >>\n\n";
        $textoRespuesta .= $this->armarReferencia($cita);

        return $textoRespuesta;
    }

    protected function armarReferencia($cita)
    {
        $referencia = "- ";
        $referencia .= "{$cita->autor->nombre}";
        $referencia .= ", " . '"' . $cita->fuente->titulo . '"';

        if ($cita->fuente->nombre_revista != "") {
            $referencia .= ",  {$cita->fuente->nombre_revista}";

            if ($cita->fuente->fecha_publicacion) {
                $referencia .= ", {$cita->fuente->fecha_publicacion}";
            }
        }

        if ($cita->fuente->numero_pagina != "") {
            $referencia .= ", pág. {$cita->fuente->numero_pagina}";
        }

        return $referencia;
    }

    public function getDailyCita()
    {
        $cita = CitaCita::with('autor', 'fuente')->inRandomOrder()->first();
        if (!$cita) {
            return null;
        }
        $referencia = $this->armarReferencia($cita);
        $cita->referencia = $referencia;

        return $cita;
    }
}
