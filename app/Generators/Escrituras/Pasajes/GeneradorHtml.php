<?php

namespace App\Generators\Escrituras\Pasajes;

use App\Generators\Contracts\GeneradorPasajeInterface;

class GeneradorHtml implements GeneradorPasajeInterface
{
    /**
     * Genera la salida de los versículos en formato HTML.
     *
     * @param  \Illuminate\Support\Collection  $versiculos  Colección de versículos a formatear.
     * @param  string  $referenciaFinal  Referencia final del pasaje.
     * @return string
     */
    public function generar($versiculos, $referenciaFinal,$titulo=null)
    {
        // Inicializa el contenedor HTML.
        $html = '<blockquote class="pasaje">';

        // Itera sobre cada versículo y lo añade al contenedor HTML.
        foreach ($versiculos as $versiculo) {
            $html .= sprintf(
                '
<div>%d %s</div>',
                $versiculo->num_versiculo,
                e($versiculo->contenido) // Usa la función e() para escapar el contenido y evitar inyección de HTML
            );
        }

        // Añade la referencia final como un elemento <cite> alineado a la derecha.
        $html .= sprintf(
            '
 <cite class="text-end">- %s</cite>',
            e($referenciaFinal) // Escapa la referencia final por seguridad
        );

        // Cierra el blockquote.
        $html .= '
</blockquote>';

        return $html;
    }
}
