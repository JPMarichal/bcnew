<?php

namespace App\Generators\Escrituras\Pasajes;

use App\Generators\Contracts\GeneradorPasajeInterface;
use Illuminate\Support\Collection;

class GeneradorJson implements GeneradorPasajeInterface
{
    /**
     * Genera la salida de los versículos en formato JSON.
     *
     * @param  Collection  $versiculos  Colección de versículos a formatear.
     * @param  string  $referenciaFinal  Referencia final del pasaje.
     * @return string
     */
    public function generar($versiculos, $referenciaFinal,$titulo=null)
    {
        $datosPasaje = [
            'titulo' => $titulo,
            'versiculos' => $versiculos->map(function ($versiculo) {
                return [
                    'num_versiculo' => $versiculo->num_versiculo,
                    'contenido' => $versiculo->contenido
                ];
            })->toArray(),
            'referencia' => $referenciaFinal
        ];

        return json_encode($datosPasaje);
    }
}
