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
     * @return string La ruta pública de la imagen convertida y guardada.
     */
    public function convertImageFromUrl($imageUrl, $format = 'webp')
    {
        $imageContent = file_get_contents($imageUrl);
        if (!$imageContent) {
            return 'No se pudo obtener la imagen.';
        }

        $image = imagecreatefromstring($imageContent);
        if (!$image) {
            return 'No se pudo crear la imagen.';
        }

        // Genera un nombre único para el archivo.
        $fileName = uniqid('image_', true) . '.' . $format;
        // Usa el sistema de archivos local de Laravel para el almacenamiento temporal.
        $filePath = 'public/tmp/' . $fileName;

        switch ($format) {
            case 'webp':
                imagewebp($image, storage_path('app/' . $filePath));
                break;
            case 'png':
                imagepng($image, storage_path('app/' . $filePath));
                break;
            default:
                imagedestroy($image);
                return 'Formato no soportado.';
        }

        imagedestroy($image);

        // Devuelve la ruta pública para el acceso a la imagen.
        return Storage::url($filePath);
    }
}
