<?php

namespace App\Services\FeedProcessors;

use App\Contracts\FeedProcessorInterface;
use SimpleXMLElement;
use App\Models\NewsItem;

class MasFeNewsFeedProcessor implements FeedProcessorInterface
{
    public function processFeed(string $feedUrl): void
    {
        $feed = simplexml_load_file($feedUrl);

        foreach ($feed->channel->item as $item) {
            $link = (string) $item->link;
            $title = (string) $item->title;
            $description = (string) $item->description;
            $pubDate = new \DateTime((string) $item->pubDate);
            $author = (string) $item->children('http://purl.org/dc/elements/1.1/')->creator;

            // Asumiendo que el campo 'content:encoded' contiene el contenido completo del artículo
            $content = (string) $item->children('http://purl.org/rss/1.0/modules/content/')->encoded;

            if (!NewsItem::where('link', $link)->exists()) {
                NewsItem::create([
                    'title' => $title,
                    'description' => $description,
                    'link' => $link,
                    'pub_date' => $pubDate,
                    'author' => $author,
                    'source' => 'Más Fe',
                    'featured_image' => '', // Considera extraer y procesar imágenes si están disponibles
                    'content' => $content,
                ]);
            }
        }

        // Aquí puedes implementar la lógica para mantener el límite de registros si es necesario
    }
}
