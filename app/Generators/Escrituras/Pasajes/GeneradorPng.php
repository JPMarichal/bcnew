<?php

namespace App\Generators\Escrituras\Pasajes;

use App\Generators\Contracts\GeneradorPasajeInterface;
use Illuminate\Support\Collection;

class GeneradorPng implements GeneradorPasajeInterface
{
    public function generar($versiculos, $referenciaFinal, $titulo = null)
    {
        $ancho = 1920;
        $alto = 1080;
        $imagen = imagecreatetruecolor($ancho, $alto);
        $charsperline = 55; // Cantidad de caracteres por línea.

        $colorTexto = imagecolorallocate($imagen, 240, 230, 220);
        $colorFondo = imagecolorallocate($imagen, 100, 60, 20);
        $colorRect = imagecolorallocate($imagen, (240 + 100) / 2, (230 + 60) / 2, (220 + 20) / 2);
        $colorReferencia = imagecolorallocate($imagen, (170 + 100) / 2, (145 + 60) / 2, (120 + 20) / 2);

        imagefill($imagen, 0, 0, $colorFondo);

        imagefilledrectangle($imagen, 50, 50, 1870, 200, $colorRect);
        imagefilledrectangle($imagen, 50, 250, 1870, 1030, $colorRect);



        $fuente = public_path('fonts/OpenSans/OpenSans-Bold.ttf');

        $tamanoTexto = 45; // Tamaño inicial del texto

        $y = 350; // Inicio de Y, deja espacio para un título

        foreach ($versiculos as $versiculo) {
            $texto = wordwrap("{$versiculo->num_versiculo} {$versiculo->contenido}", $charsperline, "\n");
            // Divide el texto en líneas
            $lineas = explode("\n", $texto);
            foreach ($lineas as $linea) {
                imagettftext($imagen, $tamanoTexto, 0, 100, $y, $colorTexto, $fuente, $linea);
                $y += $tamanoTexto * 1.7; // Ajusta Y para la siguiente línea
            }
        }


        $y += $tamanoTexto * 1.7; // Ajusta Y para la siguiente línea
        // Alinea la referencia final a la derecha y abajo
        $bbox = imagettfbbox($tamanoTexto, 0, $fuente, $referenciaFinal);
        $x = $ancho - $bbox[2] - 100; // Calcula X basado en el ancho del texto
        imagefilledrectangle($imagen, 50, $alto - 160, 1870, $alto - 90, $colorReferencia);
        //  imagettftext($imagen, $tamanoTexto, 0, $x, $alto - 100, $colorTexto, $fuente, $referenciaFinal);
        imagettftext($imagen, $tamanoTexto, 0, $x, $alto - 105, $colorTexto, $fuente, $referenciaFinal);

        if ($titulo !== null) {
            // Define el color del texto del título, por ejemplo, ámbar
            $colorTitulo = imagecolorallocate($imagen, 255, 193, 7); // Ámbar
            // Asume que ya tienes definida la fuente y tamaño del título
            imagettftext($imagen, 70, 0, 75, 155, $colorTitulo, $fuente, $titulo);
        }

        // Envía la imagen al navegador
        /* header('Content-Type: image/png');
        imagepng($imagen);
        imagedestroy($imagen);*/
        // Guarda la imagen en un archivo temporal
        $rutaTemporal = tempnam(sys_get_temp_dir(), 'gen_png_') . '.png';
        imagepng($imagen, $rutaTemporal);
        imagedestroy($imagen);

        // Ahora puedes retornar la ruta del archivo temporal para ser usada por otros procesos
        return $rutaTemporal;
    }
}
