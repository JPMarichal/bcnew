<?php

namespace App\Services\FeedProcessors;

use App\Contracts\FeedProcessorInterface;
use SimpleXMLElement;
use App\Models\NewsItem;

class DefaultFeedProcessor implements FeedProcessorInterface
{
    public function processFeed(string $feedUrl): void
    {
        $feed = simplexml_load_file($feedUrl);

        foreach ($feed->channel->item as $item) {
            $link = (string) $item->link;
            $parsedUrl = parse_url($link);
            $source = $parsedUrl['host']; // Obtiene el dominio del link
        
            if (!NewsItem::where('link', $link)->exists()) {
                NewsItem::create([
                    'title' => (string) $item->title,
                    'description' => (string) $item->description,
                    'link' => $link,
                    'pub_date' => (string) $item->pubDate,
                    'author' => (string) $item->author ?? 'Desconocido', // Maneja la posibilidad de que no haya autor
                    'source' => $source, // Usa el dominio como fuente
                    'featured_image' => '', // Asume que no hay imagen destacada en el feed
                    'content' => (string) $item->description,
                ]);
            }
        }
        
        // Lógica para mantener el límite de registros
        while (NewsItem::count() > 1000) {
            NewsItem::orderBy('pub_date', 'asc')->first()->delete();
        }
    }
}
