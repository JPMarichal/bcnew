<?php
namespace App\Services\FeedProcessors;

use App\Contracts\FeedProcessorInterface;
use SimpleXMLElement;
use App\Models\NewsItem;
use App\Services\NewsContentScrapers\LaIglesiaDeJesucristoScraper;

class LdsNewsFeedProcessor implements FeedProcessorInterface
{
    protected $country;
    protected $language;

    public function __construct(string $country, string $language = 'es')
    {
        $this->country = $country;
        $this->language = $language;
    }

    public function processFeed(string $feedUrl): void
    {
        $feed = simplexml_load_file($feedUrl);
        $scraper = new LaIglesiaDeJesucristoScraper();

        foreach ($feed->channel->item as $item) {
            $link = (string) $item->link;
            $source = 'La Iglesia de Jesucristo - ' . $this->country; // La fuente varía según el país

            $content = $scraper->extractContent($link);
            $featuredImage = $scraper->extractFeaturedImage($link);
            $description = $scraper->extractDescription($link);
            $author = $scraper->extractAuthor($link);

            if (!NewsItem::where('link', $link)->exists()) {
                NewsItem::create([
                    'title' => trim((string) $item->title),
                    'description' => $description,
                    'link' => $link,
                    'pub_date' => (new \DateTime((string) $item->pubDate))->format('Y-m-d H:i:s'),
                    'author' => $author ?? 'Desconocido', // Asume un valor por defecto si no hay autor
                    'source' => $source,
                    'featured_image' => $featuredImage, 
                    'content' => $content,
                    'language' => $this->language // La lengua puede variar, aunque por ahora asumimos 'es'
                ]);
            }
        }
    }
}
