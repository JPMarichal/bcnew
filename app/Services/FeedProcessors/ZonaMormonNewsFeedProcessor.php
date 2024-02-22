<?php

namespace App\Services\FeedProcessors;

use App\Contracts\FeedProcessorInterface;
use SimpleXMLElement;
use App\Models\NewsItem;

class ZonaMormonNewsFeedProcessor implements FeedProcessorInterface
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
            $images = $this->extractMediaContent($item);

            if (!NewsItem::where('link', $link)->exists()) {
                NewsItem::create([
                    'title' => $title,
                    'description' => $description,
                    'link' => $link,
                    'pub_date' => $pubDate,
                    'author' => $author,
                    'source' => 'Zona Mormón',
                    'featured_image' => $images[0] ?? '', // Tomamos la primera imagen como destacada
                    'content' => $description,
                    'language' => 'es'
                ]);
            }
        }

        // Mantener el límite de registros
        while (NewsItem::count() > 1000) {
            NewsItem::orderBy('pub_date', 'asc')->first()->delete();
        }
    }

    protected function extractMediaContent(SimpleXMLElement $item): array
    {
        $images = [];
        foreach ($item->children('http://search.yahoo.com/mrss/')->content as $content) {
            $url = (string) $content->attributes()->url;
            if (!empty($url)) {
                $images[] = $url;
            }
        }
        return $images;
    }
}
