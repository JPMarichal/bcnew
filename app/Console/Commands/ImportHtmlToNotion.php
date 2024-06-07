<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use FiveamCode\LaravelNotionApi\Notion;
use FiveamCode\LaravelNotionApi\Entities\Blocks\HeadingOne;
use FiveamCode\LaravelNotionApi\Entities\Blocks\HeadingTwo;
use FiveamCode\LaravelNotionApi\Entities\Blocks\HeadingThree;
use FiveamCode\LaravelNotionApi\Entities\Blocks\Paragraph;
use FiveamCode\LaravelNotionApi\Entities\Blocks\Quote;
use FiveamCode\LaravelNotionApi\Entities\Blocks\Image;
use FiveamCode\LaravelNotionApi\Entities\Blocks\BulletedListItem;
use FiveamCode\LaravelNotionApi\Entities\Blocks\NumberedListItem;
use FiveamCode\LaravelNotionApi\Entities\Blocks\TextBlock;
use FiveamCode\LaravelNotionApi\Entities\Page;
use FiveamCode\LaravelNotionApi\Entities\Properties\Title;
use FiveamCode\LaravelNotionApi\Entities\Properties\Relation;
use Illuminate\Support\Facades\File;
use DOMDocument;
use Exception;

class ImportHtmlToNotion extends Command
{
    protected $signature = 'import:html-to-notion';
    protected $description = 'Import HTML files to Notion';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Initialize Notion client with retry configuration
        $notion = new Notion(env('NOTION_API_TOKEN'));

        $parentDatabaseId = env('NOTION_DATABASE_ID_LIBROS');
        $childDatabaseId = env('NOTION_DATABASE_ID_CAPITULOS');

        // Path to HTML directories
        $baseDir = 'P:/Biblib/BDE/spa/html';
        $doneDir = $baseDir . '/done';

        // Create the 'done' directory if it doesn't exist
        if (!File::exists($doneDir)) {
            File::makeDirectory($doneDir);
        }

        // Get directories, excluding ., .. and done
        $directories = array_filter(scandir($baseDir), function ($dir) use ($baseDir, $doneDir) {
            return $dir !== '.' && $dir !== '..' && $dir !== 'done' && is_dir($baseDir . '/' . $dir);
        });

        foreach ($directories as $directory) {
            $dirPath = $baseDir . '/' . $directory;
            $doneSubDir = $doneDir . '/' . $directory;

            // Create the 'done' subdirectory if it doesn't exist
            if (!File::exists($doneSubDir)) {
                File::makeDirectory($doneSubDir);
            }

            if (is_dir($dirPath)) {
                $this->info("Processing directory: $directory");

                // Create a page for the book
                $page = new Page();
                $page->set('title', Title::value($directory));

                // Additional properties for the book can be set here
                // $page->set('Autor', Text::value('Autor del libro'));
                // $page->set('Año', Text::value('2021'));

                $mainPage = $this->createNotionPageWithRetry($notion, $parentDatabaseId, $page);

                $htmlFiles = scandir($dirPath);

                foreach ($htmlFiles as $file) {
                    $filePath = $dirPath . '/' . $file;
                    $doneFilePath = $doneSubDir . '/' . $file;

                    if (pathinfo($filePath, PATHINFO_EXTENSION) == 'html' && !File::exists($doneFilePath)) {
                        $this->info("Processing file: $file");

                        // Read HTML content
                        $htmlContent = File::get($filePath);

                        // Convert HTML to Notion blocks
                        $blocks = $this->convertHtmlToBlocks($htmlContent);

                        // Create a page for the chapter in the child database
                        $chapterPage = new Page();
                        $chapterPage->set('title', Title::value(pathinfo($file, PATHINFO_FILENAME)));
                        $chapterPage->set('Libros', Relation::value([$mainPage->getId()]));

                        // Additional properties for the chapter can be set here
                        // $chapterPage->set('Autor', Text::value('Autor del capítulo'));
                        // $chapterPage->set('Etiquetas', MultiSelect::value(['Etiqueta1', 'Etiqueta2']));

                        $createdChapterPage = $this->createNotionPageWithRetry($notion, $childDatabaseId, $chapterPage);

                        // Append blocks to the chapter page
                        foreach ($blocks as $block) {
                            $this->appendNotionBlockWithRetry($notion, $createdChapterPage->getId(), $block);
                        }

                        // Move the processed file to 'done' subdirectory
                        File::move($filePath, $doneFilePath);
                    }
                }

                // Remove the processed directory if all files are moved to 'done'
                if (count(scandir($dirPath)) == 2) { // Only . and .. are left
                    File::deleteDirectory($dirPath);
                }
            }
        }
    }

    private function cleanHtmlContent($element)
    {
        $cleanedContent = '';

        foreach ($element->childNodes as $child) {
            if ($child->nodeType == XML_TEXT_NODE) {
                $cleanedContent .= $child->textContent;
            } elseif ($child->nodeType == XML_ELEMENT_NODE) {
                if ($child->tagName == 'img') {
                    $src = $child->getAttribute('src');
                    if (filter_var($src, FILTER_VALIDATE_URL)) {
                        $cleanedContent .= Image::create($src);
                    }
                } else {
                    $cleanedContent .= strip_tags($child->textContent);
                }
            }
        }

        return utf8_decode($cleanedContent);
    }

    private function convertHtmlToBlocks($htmlContent)
    {
        $blocks = [];
        $dom = new DOMDocument();
        @$dom->loadHTML($htmlContent);

        $supportedTags = ['p', 'h1', 'h2', 'h3', 'ul', 'ol', 'blockquote'];

        foreach ($dom->getElementsByTagName('*') as $element) {
            try {
                if (!in_array($element->tagName, $supportedTags)) {
                    $this->info("Ignoring unsupported tag: {$element->tagName}");
                    continue;
                }

                $textContent = $this->cleanHtmlContent($element);
                $this->info("Processing tag: {$element->tagName} with content: {$textContent}");

                switch ($element->tagName) {
                    case 'p':
                        $blocks[] = Paragraph::create($textContent);
                        break;
                    case 'h1':
                        $blocks[] = HeadingOne::create($textContent);
                        break;
                    case 'h2':
                        $blocks[] = HeadingTwo::create($textContent);
                        break;
                    case 'h3':
                        $blocks[] = HeadingThree::create($textContent);
                        break;
                    case 'ul':
                        foreach ($element->getElementsByTagName('li') as $li) {
                            $liContent = $this->cleanHtmlContent($li);
                            $blocks[] = BulletedListItem::create($liContent);
                        }
                        break;
                    case 'ol':
                        foreach ($element->getElementsByTagName('li') as $li) {
                            $liContent = $this->cleanHtmlContent($li);
                            $blocks[] = NumberedListItem::create($liContent);
                        }
                        break;
                    case 'blockquote':
                        $blocks[] = Quote::create($textContent);
                        break;
                    default:
                        $this->info('Block: ' . $element->tagName);
                        break;
                }
            } catch (Exception $e) {
                $this->error("Error processing element {$element->tagName} with content '{$textContent}': " . $e->getMessage());
            }
        }

        return $blocks;
    }

    private function createNotionPageWithRetry(Notion $notion, $databaseId, Page $page)
    {
        return retry(5, function () use ($notion, $databaseId, $page) {
            return $notion->pages()->createInDatabase($databaseId, $page);
        }, 100);
    }

    private function appendNotionBlockWithRetry(Notion $notion, $pageId, $block)
    {
        retry(5, function () use ($notion, $pageId, $block) {
            $notion->block($pageId)->append($block);
        }, 100);
    }
}
