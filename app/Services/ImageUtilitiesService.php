<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageUtilitiesService
{
    /**
     * Convierte la imagen de una URL a formato webp y la guarda en un directorio temporal.
     *
     * @param string $imageUrl La URL de la imagen.
     * @param string $format El formato deseado ('webp' o 'png').
     * @return string La ruta pública de la imagen convertida y guardada o un mensaje de error.
     */
    public function convertImageFromUrl($imageUrl, $format = 'webp')
    {
        // Intenta obtener el contenido de la imagen de la URL.
        try {
            $imageContent = file_get_contents($imageUrl);
            if (!$imageContent) {
                throw new \Exception('No se pudo obtener la imagen desde la URL.');
            }
        } catch (\Exception $e) {
            return 'Error al descargar la imagen: ' . $e->getMessage();
        }

        // Intenta crear una imagen a partir del contenido obtenido.
        try {
            $image = imagecreatefromstring($imageContent);
            if (!$image) {
                throw new \Exception('No se pudo crear la imagen a partir del contenido.');
            }
        } catch (\Exception $e) {
            return 'Error al crear la imagen: ' . $e->getMessage();
        }

        // Genera un nombre único para el archivo.
        $fileName = uniqid('image_', true) . '.' . $format;
        // Define la ruta en el sistema de archivos local de Laravel.
        $filePath = 'public/tmp/' . $fileName;

        // Intenta guardar la imagen en el formato especificado.
        try {
            switch ($format) {
                case 'webp':
                    if (!imagewebp($image, storage_path('app/' . $filePath))) {
                        throw new \Exception('No se pudo convertir la imagen a WEBP.');
                    }
                    break;
                case 'png':
                    if (!imagepng($image, storage_path('app/' . $filePath))) {
                        throw new \Exception('No se pudo convertir la imagen a PNG.');
                    }
                    break;
                default:
                    imagedestroy($image);
                    return 'Formato no soportado.';
            }
        } catch (\Exception $e) {
            imagedestroy($image);
            return 'Error al guardar la imagen: ' . $e->getMessage();
        }

        // Destruye la imagen en memoria para liberar recursos.
        imagedestroy($image);

        // Devuelve la ruta pública para el acceso a la imagen.
        return Storage::url($filePath);
    }
}
