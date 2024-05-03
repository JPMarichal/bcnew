<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Blog\Post;
use FiveamCode\LaravelNotionApi\Notion;
use Illuminate\Support\Str;

class ImportPostsFromNotion extends Command
{
    protected $signature = 'posts:import-notion';
    protected $description = 'Importa posts desde una base de datos de Notion';

    public function handle()
    {
        $notion = new Notion(env('NOTION_API_TOKEN'));
        $databaseId = config(env('NOTION_DATABASE_ID'));
        $pages = $notion->database($databaseId)->query()->asCollection();

        foreach ($pages as $page) {
            $title = $page->properties->Title->title[0]->plain_text;
            $blocks = $notion->block($page->id)->children()->asCollection(); // Obtiene los bloques de la página
            $contentHtml = $this->notionToHtml($blocks);

            Post::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'content' => $contentHtml,
                'excerpt' => substr(strip_tags($contentHtml), 0, 200), // Genera un extracto eliminando etiquetas HTML
                'author_id' => 1, // Asumiendo un autor predeterminado
                'status' => 'draft',
                'publish_date' => now(),
                'post_type' => 'post',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $this->info("Imported: {$title}");
        }

        $this->info('All posts have been imported successfully from Notion.');
    }

    function notionToHtml($blocks)
    {
        $html = '';
        foreach ($blocks as $block) {
            switch ($block->type) {
                case 'paragraph':
                    $html .= '<p>' . htmlspecialchars($block->paragraph->text[0]->plain_text) . '</p>';
                    break;
                case 'heading_1':
                    $html .= '<h1>' . htmlspecialchars($block->heading_1->text[0]->plain_text) . '</h1>';
                    break;
                case 'heading_2':
                    $html .= '<h2>' . htmlspecialchars($block->heading_2->text[0]->plain_text) . '</h2>';
                    break;
                case 'heading_3':
                    $html .= '<h3>' . htmlspecialchars($block->heading_3->text[0]->plain_text) . '</h3>';
                    break;
                case 'bulleted_list_item':
                    $html .= '<li>' . htmlspecialchars($block->bulleted_list_item->text[0]->plain_text) . '</li>';
                    break;
                    // Agrega otros tipos de bloques según sea necesario
                default:
                    $html .= '<div>' . htmlspecialchars($block->type) . '</div>'; // Fallback para tipos no manejados
            }
        }
        return $html;
    }
}
