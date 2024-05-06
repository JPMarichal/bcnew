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
        // dd($databaseId);

        if (is_null($token) || is_null($databaseId)) {
            $this->error('API token or Database ID is not set in .env file.');
            return;
        }
        // dd($token, $databaseId);

        $notion = new Notion($token);
        $pages = $notion->database($databaseId)->query()->asCollection();

        foreach ($pages as $page) {
            $title = $page->getTitle();
            $excerpt = $page->getProperty('Excerpt')->getPlainText();
            $pageId = $page->getPageId();
           // dd($pageId);

            //  $blocks = $notion->block($page->getId())->children()->asCollection(); // Obtiene los bloques de la página
            //  $contentHtml = $this->notionToHtml($blocks);

            $contentHtml = (new NotionRenderer($pageId))->html();

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

            $this->info("Imported: {$title}");
        }

        $this->info('All posts have been imported successfully from Notion.');
    }

    function notionToHtml($blocks)
    {
        $html = '';
        foreach ($blocks as $block) {
            switch ($block->getType()) {
                case 'paragraph':
                    $plainText = trim($block->getContent()->getPlainText());
                    $html .= '<p>' . htmlspecialchars($plainText) . '</p>';
                    // dd($html);
                    break;
                case 'heading_1':
                    $plainText = trim($block->getContent()->getPlainText());
                    $html .= '<h1>' . htmlspecialchars($plainText) . '</h1>';
                    break;
                case 'heading_2':
                    $plainText = trim($block->getContent()->getPlainText());
                    $html .= '<h2>' . htmlspecialchars($plainText) . '</h2>';
                    break;
                case 'heading_3':
                    $plainText = trim($block->getContent()->getPlainText());
                    $html .= '<h3>' . htmlspecialchars($plainText) . '</h3>';
                    break;
                case 'bulleted_list_item':
                    $plainText = trim($block->getContent()->getPlainText());
                    $html .= '<li>' . htmlspecialchars($plainText) . '</li>';
                    break;
                case 'numbered_list_item':
                    $plainText = trim($block->getContent()->getPlainText());
                    $html .= '<li>' . htmlspecialchars($plainText) . '</li>';
                    break;
                case 'quote':
                    $plainText = trim($block->getContent()->getPlainText());
                    $html .= '<blockquote>' . htmlspecialchars($plainText) . '</blockquote>';
                    break;
                    // Agrega otros tipos de bloques según sea necesario
                default:
                    $html .= '<div>' . htmlspecialchars($block->type) . '</div>'; // Fallback para tipos no manejados
            }
        }
        return $html;
    }
}
