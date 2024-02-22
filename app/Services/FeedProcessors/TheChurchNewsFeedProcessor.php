<?php

namespace App\Services\FeedProcessors;

use App\Contracts\FeedProcessorInterface;
use SimpleXMLElement;
use App\Models\NewsItem;

class TheChurchNewsFeedProcessor implements FeedProcessorInterface
{
    public function processFeed(string $feedUrl): void
    {
        $feed = simplexml_load_file($feedUrl);
        $ns = $feed->getNamespaces(true); // Obtener los namespaces

        foreach ($feed->entry as $entry) {
            $link = (string) $entry->link['href'];
            $source = 'The Church News';
            $title = (string) $entry->title;
            $description = strip_tags((string) $entry->content); // Eliminamos las etiquetas HTML del contenido
            $publishedDate = new \DateTime((string) $entry->published);
            $author = (string) $entry->author->name;

            if (!NewsItem::where('link', $link)->exists()) {
                NewsItem::create([
                    'title' => $title,
                    'description' => $description,
                    'link' => $link,
                    'pub_date' => $publishedDate,
                    'author' => $author,
                    'source' => $source,
                    'featured_image' => '', // Necesitarás ajustar esto si quieres manejar imágenes
                    'content' => $description,
                    'language' => 'es'
                ]);
            }
        }
    }
}
