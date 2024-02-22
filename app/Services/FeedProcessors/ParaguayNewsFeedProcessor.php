<?php

namespace App\Services\FeedProcessors;

use App\Contracts\FeedProcessorInterface;
use SimpleXMLElement;
use App\Models\NewsItem;
use App\Services\NewsContentScrapers\LaIglesiaDeJesucristoScraper;

class ParaguayNewsFeedProcessor implements FeedProcessorInterface
{
    public function processFeed(string $feedUrl): void
    {
        $feed = simplexml_load_file($feedUrl);
        $scraper = new LaIglesiaDeJesucristoScraper();

        foreach ($feed->channel->item as $item) {
            $link = (string) $item->link;
            $source = 'La Iglesia de Jesucristo - Paraguay'; // Fuente específica para este procesador

            $content = $scraper->extractContent($item->link);
            $featuredImage = $scraper->extractFeaturedImage($item->link);
            $description = $scraper->extractDescription($item->link);
            $author = $scraper->extractAuthor($item->link);

            if (!NewsItem::where('link', $link)->exists()) {
                NewsItem::create([
                    'title' => trim((string) $item->title),
                    'description' => $description,
                    'link' => $link,
                    'pub_date' => (string) $item->pubDate,
                    'author' => $author ?? 'Desconocido', // Asume un valor por defecto si no hay autor
                    'source' => $source,
                    'featured_image' => $featuredImage, 
                    'content' => $content,
                    'language' => 'es'
                ]);
            }
        }
    }
}
