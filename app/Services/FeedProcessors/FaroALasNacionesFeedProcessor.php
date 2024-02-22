<?php

namespace App\Services\FeedProcessors;

use App\Contracts\FeedProcessorInterface;
use SimpleXMLElement;
use App\Models\NewsItem;

class FaroALasNacionesFeedProcessor implements FeedProcessorInterface
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

            if (!NewsItem::where('link', $link)->exists()) {
                NewsItem::create([
                    'title' => $title,
                    'description' => $description,
                    'link' => $link,
                    'pub_date' => $pubDate,
                    'author' => $author,
                    'source' => 'Faro a las Naciones',
                    'featured_image' => '', // Necesitarás extraer y procesar las imágenes si están disponibles
                    'content' => 'content:encoded', // O usa 'content:encoded' si necesitas el contenido HTML completo
                    'language' => 'es'
                ]);
            }
        }

        // Mantener el límite de registros
        while (NewsItem::count() > 1000) {
            NewsItem::orderBy('pub_date', 'asc')->first()->delete();
        }
    }
}
