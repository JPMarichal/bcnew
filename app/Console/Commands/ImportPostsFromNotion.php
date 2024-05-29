<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Blog\Post;
use FiveamCode\LaravelNotionApi\Notion;
use Illuminate\Support\Str;
use RehanKanak\LaravelNotionRenderer\Renderers\NotionRenderer;
use App\Services\ImageUploadService;
use App\Services\BunnyCDNService;
use Illuminate\Support\Facades\Http;

class ImportPostsFromNotion extends Command
{
    protected $signature = 'posts:import-notion';
    protected $description = 'Importa posts desde una base de datos de Notion';

    public function handle()
    {
        $token = env('NOTION_API_TOKEN');
        $databaseId = env('NOTION_DATABASE_ID');
        $notionVersion = '2022-06-28'; // Especifica la versión de la API de Notion que estás usando

        if (is_null($token) || is_null($databaseId)) {
            $this->error('API token or Database ID is not set in .env file.');
            return;
        }

        $notion = new Notion($token);
        $pages = $notion->database($databaseId)->query()->asCollection();
        $pages = $pages->filter(function ($page) {
            return $page->getProperty('Status')->getContent()->getName() === 'Para publicar';
        });

        foreach ($pages as $page) {
            $title = $page->getTitle();

            // Crea el post solamente si no existe 
            if (Post::where('title', $title)->exists()) {
                $this->info("El post {$title} ya existe.");
                continue;
            }

            $excerpt = $page->getProperty('Excerpt')->getPlainText();
            $pageId = $page->getPageId();
            $contentHtml = (new NotionRenderer($pageId))->html();

            // Crea el post solamente si el contenido no está vacío
            if (empty($contentHtml)) {
                $this->info("El post {$title} no tiene contenido.");
                continue;
            }

            $cover = $page->getCover();

            $post = Post::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'content' => $contentHtml,
                'excerpt' => $excerpt, 
                'author_id' => 1, // Asumiendo un autor predeterminado
                'status' => 'published',
                'publish_date' => now(),
                'post_type' => 'post',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $this->info("Se importó: {$title}");

            $postId = $post->id;

            $cdnService = new BunnyCDNService();
            $uploadService = new ImageUploadService($cdnService);
            $uploadService->uploadImageURLToCDN($postId, $cover);

            // Actualiza el estado de la página en Notion a "Publicado" y el PostId
            $this->updateNotionPageStatus($notion, $pageId, 'Publicado', $postId, $notionVersion);
        }

        $this->info('All posts have been imported successfully from Notion.');
    }

    private function updateNotionPageStatus(Notion $notion, string $pageId, string $newStatus, int $postId, string $notionVersion)
    {
        $url = "https://api.notion.com/v1/pages/{$pageId}";
        $token = env('NOTION_API_TOKEN');
        $data = [
            'properties' => [
                'Status' => [
                    'select' => [
                        'name' => $newStatus
                    ]
                ],
                'PostId' => [
                    'number' => $postId
                ]
            ]
        ];
        $response = Http::withToken($token)
            ->withHeaders(['Notion-Version' => $notionVersion])
            ->patch($url, $data);

        if ($response->successful()) {
            $this->info("El estado de la página {$pageId} se ha actualizado a '{$newStatus}' y el PostId a '{$postId}' en Notion.");
        } else {
            $this->error("No se pudo actualizar el estado de la página {$pageId} en Notion.");
            $this->error("Respuesta de la API: " . $response->body());
        }
    }
}
