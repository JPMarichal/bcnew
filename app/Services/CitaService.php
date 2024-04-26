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

    protected function formatearCitaComoTexto($cita)
    {
        $textoRespuesta = "{$cita->titulo}\n\n";
        $textoRespuesta .= "<< {$cita->texto} >>\n\n";
        $textoRespuesta .= $this->armarReferencia($cita);

        return $textoRespuesta;
    }

    protected function armarReferencia($cita)
    {
        $referencia = "- ";
        $referencia .= "{$cita->autor->nombre}";
        $referencia .= ", ". '"'. $cita->fuente->titulo . '"'; 

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
}
