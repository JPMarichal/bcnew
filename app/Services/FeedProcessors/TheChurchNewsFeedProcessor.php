<?php
namespace App\Services\FeedProcessors;

use App\Contracts\FeedProcessorInterface;
use SimpleXMLElement;
use App\Models\NewsItem;
use App\Services\NewsContentScrapers\TheChurchNewsScraper; // Asegúrate de usar el scraper correcto

class TheChurchNewsFeedProcessor implements FeedProcessorInterface
{
    public function processFeed(string $feedUrl): void
    {
        $feed = simplexml_load_file($feedUrl);
        $feed->registerXPathNamespace('media', 'http://search.yahoo.com/mrss/');
        $scraper = new TheChurchNewsScraper(); // Instancia el scraper directamente

        foreach ($feed->channel->item as $item) {
            $link = (string) $item->link;
            $title = (string) $item->title;

            // Si no hay título, no se realiza ninguna extracción
            if (empty($title)) {
                continue;
            }

            if (!NewsItem::where('link', $link)->exists()) {
                // Utiliza el scraper para obtener los datos
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
                    'author' => $author,
                    'source' => 'The Church News',
                    'featured_image' => $featuredImage,
                    'content' => $content,
                    'language' => 'es'
                ]);
            }
        }
    }
}
