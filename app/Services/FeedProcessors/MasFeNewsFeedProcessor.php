<?php
namespace App\Services\FeedProcessors;

use App\Contracts\FeedProcessorInterface;
use SimpleXMLElement;
use App\Models\NewsItem;
use App\Services\NewsContentScrapers\MasFeScraper;
use DateTime;

class MasFeNewsFeedProcessor implements FeedProcessorInterface
{
    public function processFeed(string $feedUrl): void
    {
        $feed = simplexml_load_file($feedUrl);
        $scraper = new MasFeScraper();

        // Calcula la fecha de hace n días
        $dateLimit = new DateTime(env('DAYS2RETRIEVE'));

        foreach ($feed->channel->item as $item) {
            $link = (string) $item->link;
            $title = (string) $item->title;

            if (empty($title) || NewsItem::where('link', $link)->exists()) {
                continue;
            }

            // Ajuste para el formato de fecha RFC 2822
            $publishedDate = DateTime::createFromFormat(DateTime::RFC2822, (string) $item->pubDate);

            if (!$publishedDate || $publishedDate < $dateLimit) {
                continue; // El ítem es más antiguo que 30 días o la fecha es inválida, se salta.
            }

            // Preparar el scraper con la URL del artículo
            $scraper->prepare($link);

            $description = $scraper->extractDescription();
            $content = $scraper->extractContent();
            $featuredImage = $scraper->extractFeaturedImage();
            $author = $scraper->extractAuthor();

            NewsItem::create([
                'title' => $title,
                'description' => $description,
                'link' => $link,
                'pub_date' => $publishedDate->format('Y-m-d H:i:s'),
                'author' => $author ?: 'Autor desconocido',
                'source' => 'Más Fe',
                'featured_image' => $featuredImage,
                'content' => trim($content),
                'language' => 'es'
            ]);
        }
    }
}
