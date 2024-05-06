<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Blog\Post;
use FiveamCode\LaravelNotionApi\Notion;
use Illuminate\Support\Str;
use RehanKanak\LaravelNotionRenderer\Renderers\NotionRenderer;

class ImportPostsFromNotion extends Command
{
    protected $signature = 'posts:import-notion';
    protected $description = 'Importa posts desde una base de datos de Notion';

    public function handle()
    {
        $token = env('NOTION_API_TOKEN');
        $databaseId = env('NOTION_DATABASE_ID');

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

            Post::create([
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
        }

        $this->info('All posts have been imported successfully from Notion.');
    }
}
