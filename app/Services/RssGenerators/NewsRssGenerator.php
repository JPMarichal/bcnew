<?php

namespace App\Services\RssGenerators;

use App\Models\NewsPost;
use Carbon\Carbon;

class NewsRssGenerator
{
    public function generate()
    {
        $newsItems = NewsPost::orderBy('pub_date', 'desc')->take(20)->get();

        $rssFeed = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><rss version="2.0"></rss>');
        $channel = $rssFeed->addChild('channel');
        $channel->addChild('title', 'Noticias RSS Feed');
        $channel->addChild('link', url('/'));
        $channel->addChild('description', 'Últimas 20 noticias.');
        $channel->addChild('language', 'es');

        foreach ($newsItems as $newsItem) {
            $item = $channel->addChild('item');
            $item->addChild('title', $newsItem->title);
            $item->addChild('link', route('noticias.show', $newsItem->slug));
            
            $description = $newsItem->description ?? 'Descripción no disponible';
            $item->addChild('description', htmlspecialchars($description));

            // Añadir la imagen destacada usando el elemento <enclosure>
            if ($newsItem->featured_image) {
                $enclosure = $item->addChild('enclosure');
                $enclosure->addAttribute('url', $newsItem->featured_image);
                $enclosure->addAttribute('type', 'image/jpeg');
                // Opcional: $enclosure->addAttribute('length', 'TamañoDelArchivo');
            }

            $item->addChild('pubDate', Carbon::parse($newsItem->pub_date)->toRssString());
        }

        return $rssFeed->asXML();
    }
}
