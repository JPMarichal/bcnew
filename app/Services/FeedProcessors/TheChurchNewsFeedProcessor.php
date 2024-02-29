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

        $dateLimit = new DateTime(env('DAYS2RETRIEVE'));

        foreach ($feed->channel->item as $item) {
            $publishedDate = DateTime::createFromFormat('D, d M Y H:i:s O', (string) $item->pubDate);

            if (!$publishedDate) {
                continue;
            }

            if ($publishedDate < $dateLimit) {
                continue;
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
                'language' => 'es',
                'country' => 'Estados Unidos'
            ]);
        }
    }
}
