<?php
namespace App\Services;

use App\Models\Blog\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ImageUploadService
{
    protected $cdnService;

    public function __construct(BunnyCDNService $cdnService)
    {
        $this->cdnService = $cdnService;
    }

    public function uploadImageToCDN(int $postId): string
    {
        $post = Post::find($postId);

        if (!$post) {
            throw new \Exception("Post not found!");
        }

        $slug = $post->slug;
        $imagePath = "D:\\laraproj\\bcnew\\public\\storage\\tmp\\selected";
        $imageFiles = File::glob($imagePath . '\\*.webp');

        if (empty($imageFiles)) {
            throw new \Exception("No WEBP files found in the specified directory.");
        }

        $localFilePath = $imageFiles[0];
        $newFileName = $slug . '.webp';
        $remoteFilePath = $newFileName;

        // Subiendo el archivo al CDN
        $this->cdnService->upload($localFilePath, $remoteFilePath);
        $cdnUrl = "https://bcomentarios.b-cdn.net/{$newFileName}";

        // Actualizando la base de datos
        DB::statement("call sp_reemplazar_imagen(?, ?)", [$postId, $cdnUrl]);

        // Eliminando el archivo local después de una carga exitosa
        File::delete($localFilePath);

        return $cdnUrl;
    }

    public function uploadImageURLToCDN(int $postId, string $url): string
    {
        $post = Post::find($postId);

        if (!$post) {
            throw new \Exception("Post not found!");
        }

        $slug = $post->slug;
        $imagePath = $url;
        /*$imageFiles = File::glob($imagePath . '\\*.webp');

        if (empty($imageFiles)) {
            throw new \Exception("No WEBP files found in the specified directory.");
        }*/

        // Elimina el querystring del url
        $basePath = strtok($imagePath, '?');

        // Extrae del url de imagen solo la extensión
        $extension = pathinfo($basePath, PATHINFO_EXTENSION);
        $remoteFilePath = $slug . '.'. $extension;
        $remoteFilePath = strtok($remoteFilePath, '?');

      //  dd($imagePath, $remoteFilePath);

        // Subiendo el archivo al CDN
        $this->cdnService->upload($imagePath, $remoteFilePath);
        $cdnUrl = "https://bcomentarios.b-cdn.net/{$remoteFilePath}";

        // Actualizando la base de datos
        DB::statement("call sp_reemplazar_imagen(?, ?)", [$postId, $cdnUrl]);

        return $cdnUrl;
    }
}
