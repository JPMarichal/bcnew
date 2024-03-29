<?php

namespace App\Generators\Escrituras\Pasajes;

use App\Generators\Contracts\GeneradorPasajeInterface;
use Illuminate\Support\Collection;

class GeneradorPpt implements GeneradorPasajeInterface
{
    public function generar($versiculos, $referenciaFinal)
    {
        $ancho = 1920;
        $alto = 1080;
        $imagen = imagecreatetruecolor($ancho, $alto);

        $colorFondo = imagecolorallocate($imagen, 240, 230, 220);
        $colorTexto = imagecolorallocate($imagen, 100, 60, 20);

        imagefill($imagen, 0, 0, $colorFondo);

        $fuente =  public_path('fonts/OpenSans/OpenSans-Regular.ttf');

    
        $tamanoTexto = 20; // Tamaño inicial del texto
        $tamanoTexto = $this->ajustarTamanoTexto($versiculos, $ancho);

        $y = 150; // Inicio de Y, deja espacio para un título
        foreach ($versiculos as $versiculo) {
            $texto = "{$versiculo->num_versiculo} {$versiculo->contenido}";
            imagettftext($imagen, $tamanoTexto, 0, 100, $y, $colorTexto, $fuente, $texto);
            $y += $tamanoTexto * 2; // Ajusta Y para el siguiente versículo
        }

        // Alinea la referencia final a la derecha y abajo
        $bbox = imagettfbbox($tamanoTexto, 0, $fuente, $referenciaFinal);
        $x = $ancho - $bbox[2] - 100; // Calcula X basado en el ancho del texto
        imagettftext($imagen, $tamanoTexto, 0, $x, $alto - 50, $colorTexto, $fuente, $referenciaFinal);

        // Envía la imagen al navegador
        header('Content-Type: image/png');
        imagepng($imagen);
        imagedestroy($imagen);
    }

    protected function ajustarTamanoTexto($versiculos, $ancho)
    {
        // Esta es una implementación simplificada. Deberías ajustar esta lógica basada en tu contenido específico.
        $longitudMaxima = max(array_map(function ($versiculo) {
            return strlen($versiculo->contenido);
        }, $versiculos->all()));

        // Ajusta el tamaño del texto para que se ajuste al ancho de la imagen
        $tamanoTexto = min(40, ($ancho / $longitudMaxima) * 0.5);

        return $tamanoTexto;
    }
}
