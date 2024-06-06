<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use FiveamCode\LaravelNotionApi\Notion;
use FiveamCode\LaravelNotionApi\Entities\Blocks\HeadingOne;
use FiveamCode\LaravelNotionApi\Entities\Blocks\HeadingTwo;
use FiveamCode\LaravelNotionApi\Entities\Blocks\HeadingThree;
use FiveamCode\LaravelNotionApi\Entities\Blocks\Paragraph;
use FiveamCode\LaravelNotionApi\Entities\Blocks\Quote;
use FiveamCode\LaravelNotionApi\Entities\Blocks\Image;
use FiveamCode\LaravelNotionApi\Entities\Page;
use FiveamCode\LaravelNotionApi\Entities\Properties\Title;
use Illuminate\Support\Facades\File;
use DOMDocument;
use FiveamCode\LaravelNotionApi\Entities\Blocks;

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
        // Initialize Notion client
        $notion = new Notion(env('NOTION_API_TOKEN'));

        $parentDatabaseId = env('NOTION_DATABASE_ID_LIBROS');

        // Path to HTML directories
        $baseDir = 'P:/Biblib/BDE/spa/html';

        // Get first 3 directories for testing purposes
        $directories = array_slice(scandir($baseDir), 2, 1);

        foreach ($directories as $directory) {
            $dirPath = $baseDir . '/' . $directory;

            if (is_dir($dirPath)) {
                $this->info("Processing directory: $directory");

                $page = new Page();
                $page->set('title', Title::value($directory));

                $mainPage = $notion->pages()->createInDatabase($parentDatabaseId, $page);

                $htmlFiles = scandir($dirPath);

                foreach ($htmlFiles as $file) {
                    $filePath = $dirPath . '/' . $file;

                    if (pathinfo($filePath, PATHINFO_EXTENSION) == 'html') {
                        $this->info("Processing file: $file");

                        // Read HTML content
                        $htmlContent = File::get($filePath);

                        // Convert HTML to Notion blocks
                        $blocks = $this->convertHtmlToBlocks($htmlContent);

                        // Create a subpage under the directory page
                        $subPage = new Page();
                        $subPage->set('title', Title::value(pathinfo($file, PATHINFO_FILENAME)));

                        //  dd($mainPage);
                        $createdSubPage = $notion->pages()->createInPage($mainPage->getPageId(), $subPage);

                        // Append blocks to the subpage
                        foreach ($blocks as $block) {
                            $notion->block($createdSubPage->getId())->append($block);
                        }
                    }
                }
            }
        }
    }

    private function convertHtmlToBlocks($htmlContent)
    {
        // Implement a basic HTML to Notion block conversion logic
        $blocks = [];

        // Use a DOM parser to parse HTML content
        $dom = new DOMDocument();
        @$dom->loadHTML($htmlContent);

        foreach ($dom->getElementsByTagName('*') as $element) {
            switch ($element->tagName) {
                case 'p':
                    $blocks[] = Paragraph::create(utf8_decode($element->textContent));
                    break;
                case 'h1':
                    $blocks[] = HeadingOne::create(utf8_decode($element->textContent));
                    break;
                case 'h2':
                    $blocks[] = HeadingTwo::create(utf8_decode($element->textContent));
                    break;
                case 'h3':
                    $blocks[] = HeadingThree::create(utf8_decode($element->textContent));
                    break;
                case 'img':
                    $blocks[] = Image::create((string) $element->getAttribute('src'));
                    break;
                case 'ul':
                    foreach ($element->getElementsByTagName('li') as $li) {
                        $blocks[] = Blocks\BulletedListItem::create(utf8_decode($li->textContent));
                    }
                    break;
                case 'ol':
                    foreach ($element->getElementsByTagName('li') as $li) {
                        $blocks[] = Blocks\NumberedListItem::create(utf8_decode($li->textContent));
                    }
                    break;
                case 'blockquote':
                    $blocks[] = Quote::create(utf8_decode($element->textContent));
                    break;
            }
        }

        return $blocks;
    }
}
