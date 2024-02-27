<?php
namespace App\Services\FeedProcessors;

use App\Contracts\FeedProcessorInterface;
use SimpleXMLElement;
use App\Models\NewsItem;
use App\Services\NewsContentScrapers\MasFeScraper;

class MasFeNewsFeedProcessor implements FeedProcessorInterface
{
    public function processFeed(string $feedUrl): void
    {
        $feed = simplexml_load_file($feedUrl);
        $scraper = new MasFeScraper();

        foreach ($feed->channel->item as $item) {
            $link = (string) $item->link;
            $title = (string) $item->title;

            if (empty($title) || NewsItem::where('link', $link)->exists()) {
                continue;
            }

            // Preparar el scraper con la URL del artículo
            $scraper->prepare($link);

            $description = $scraper->extractDescription();
            $content = $scraper->extractContent();
            $featuredImage = $scraper->extractFeaturedImage();
            $author = $scraper->extractAuthor();
            $publishedDate = new \DateTime((string) $item->pubDate);

            NewsItem::create([
                'title' => $title,
                'description' => $description,
                'link' => $link,
                'pub_date' => $publishedDate->format('Y-m-d H:i:s'),
                'author' => $author,
                'source' => 'Más Fe',
                'featured_image' => $featuredImage,
                'content' => $content,
                'language' => 'es'
            ]);
        }
    }
}
