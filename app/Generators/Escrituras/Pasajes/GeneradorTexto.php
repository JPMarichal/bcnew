<?php

namespace App\Generators\Escrituras\Pasajes;

use App\Generators\Contracts\GeneradorPasajeInterface;

class GeneradorTexto implements GeneradorPasajeInterface
{
    /**
     * Genera la salida de los versículos en formato de texto plano.
     *
     * @param  \Illuminate\Support\Collection  $versiculos  Colección de versículos a formatear.
     * @param  string  $referenciaFinal  Referencia final del pasaje.
     * @return string
     */
    public function generar($versiculos, $referenciaFinal,$titulo=null)
    {
        // Inicializa el contenedor del texto final.
        $textoParaCompartir = '';

        // Itera sobre cada versículo y lo añade al texto final.
        foreach ($versiculos as $versiculo) {
            $textoParaCompartir .= "{$versiculo->num_versiculo} {$versiculo->contenido}\n";
        }

        // Añade la referencia final al texto.
        $textoParaCompartir .= "({$referenciaFinal})";

        return $textoParaCompartir;
    }
}
