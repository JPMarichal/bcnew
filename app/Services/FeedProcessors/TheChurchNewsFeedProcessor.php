<?php 
namespace App\Services\FeedProcessors;

use App\Contracts\FeedProcessorInterface;
use SimpleXMLElement;
use App\Models\NewsItem;
use App\Services\NewsContentScrapers\TheChurchNewsScraper;
use DateTime;
use Illuminate\Support\Facades\Log;

class TheChurchNewsFeedProcessor implements FeedProcessorInterface
{
    public function processFeed(string $feedUrl): void
    {
        $feed = simplexml_load_file($feedUrl);
        $feed->registerXPathNamespace('media', 'http://search.yahoo.com/mrss/');
        $scraper = new TheChurchNewsScraper();

        // Calcula la fecha de hace n días
        $dateLimit = new DateTime('-30 days');

        foreach ($feed->channel->item as $item) {
            $publishedDate = DateTime::createFromFormat('Y-m-d', (string) $item->pubDate);

            if (!$publishedDate) {
                continue;
            }

            // Verifica si la fecha de publicación es menor (más antigua) que el límite de 60 días.
            if ($publishedDate < $dateLimit) {
                continue; // El ítem es más antiguo que 60 días, se salta.
            }

            $link = (string) $item->link;
            $title = (string) $item->title;

            if (empty($title) || NewsItem::where('link', $link)->exists()) {
                continue;
            }

            $scraper->prepare($link);

            $description = $scraper->extractDescription();
            $content = $scraper->extractContent();
            $author = $scraper->extractAuthor();
            $featuredImage = $scraper->extractFeaturedImage();

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
