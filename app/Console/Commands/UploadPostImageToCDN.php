<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Blog\Post;
use App\Services\BunnyCDNService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class UploadPostImageToCDN extends Command
{
    protected $signature = 'cdn:upload-image {postId : The ID of the post}';
    protected $description = 'Uploads post image to BunnyCDN and updates database with the new image URL';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(BunnyCDNService $cdn)
    {
        $postId = $this->argument('postId');
        $post = Post::find($postId);

        if (!$post) {
            $this->error("Post not found!");
            return 1;
        }

        $slug = $post->slug;
        $imagePath = "D:\\laraproj\\bcnew\\public\\storage\\tmp\\selected";
        $imageFiles = File::glob($imagePath . '\\*.webp');

        if (empty($imageFiles)) {
            $this->error("No WEBP files found in the specified directory.");
            return 1;
        }

        $localFilePath = $imageFiles[0];
        $newFileName = $slug . '.webp';
        $remoteFilePath = $newFileName;

        try {
            // Subiendo el archivo al CDN
            $cdn->upload($localFilePath, $remoteFilePath);
            $cdnUrl = "https://bcomentarios.b-cdn.net/{$newFileName}";

            // Actualizando la base de datos
            DB::statement("call sp_reemplazar_imagen(?, ?)", [$postId, $cdnUrl]);

            // Eliminando el archivo local después de una carga exitosa
            File::delete($localFilePath);

            $this->info("Image uploaded and database updated successfully!");
            $this->info($cdnUrl);
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
