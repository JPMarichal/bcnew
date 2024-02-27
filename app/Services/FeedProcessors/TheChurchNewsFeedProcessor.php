<?php
namespace App\Services\FeedProcessors;

use App\Contracts\FeedProcessorInterface;
use SimpleXMLElement;
use App\Models\NewsItem;
use App\Services\NewsContentScrapers\TheChurchNewsScraper;

class TheChurchNewsFeedProcessor implements FeedProcessorInterface
{
    public function processFeed(string $feedUrl): void
    {
        $feed = simplexml_load_file($feedUrl);
        $feed->registerXPathNamespace('media', 'http://search.yahoo.com/mrss/');
        $scraper = new TheChurchNewsScraper();

        foreach ($feed->channel->item as $item) {
            $link = (string) $item->link;
            $title = (string) $item->title;

            if (empty($title) || NewsItem::where('link', $link)->exists()) {
                continue;
            }

            // Preparar el scraper una sola vez por URL
            $scraper->prepare($link);

            // Extraer los datos utilizando los métodos del scraper ya optimizados
            $description = $scraper->extractDescription($link);
            $content = $scraper->extractContent($link);
            $author = $scraper->extractAuthor($link);
            $featuredImage = $scraper->extractFeaturedImage($link);
            $publishedDate = new \DateTime((string) $item->pubDate);

            NewsItem::create([
                'title' => $title,
                'description' => $description,
                'link' => $link,
                'pub_date' => $publishedDate->format('Y-m-d H:i:s'),
                'author' => $author ?: 'Autor desconocido',
                'source' => 'The Church News',
                'featured_image' => $featuredImage,
                'content' => $content,
                'language' => 'es'
            ]);
        }
    }
}
