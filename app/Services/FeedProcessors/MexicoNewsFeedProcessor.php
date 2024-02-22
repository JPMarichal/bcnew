<?php

namespace App\Services\FeedProcessors;

use App\Contracts\FeedProcessorInterface;
use SimpleXMLElement;
use App\Models\NewsItem;

class MexicoNewsFeedProcessor implements FeedProcessorInterface
{
    public function processFeed(string $feedUrl): void
    {
        $feed = simplexml_load_file($feedUrl);

        foreach ($feed->channel->item as $item) {
            $link = (string) $item->link;
            $source = 'La Iglesia de Jesucristo - México'; // Fuente específica para este procesador

            if (!NewsItem::where('link', $link)->exists()) {
                NewsItem::create([
                    'title' => (string) $item->title,
                    'description' => (string) $item->description,
                    'link' => $link,
                    'pub_date' => (string) $item->pubDate,
                    'author' => (string) $item->author ?? 'Desconocido', // Asume un valor por defecto si no hay autor
                    'source' => $source,
                    'featured_image' => '', // Asume que no hay imagen destacada en el feed
                    'content' => (string) $item->description,
                    'language' => 'es'
                ]);
            }
        }
    }
}
