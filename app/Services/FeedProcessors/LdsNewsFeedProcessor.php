<?php
namespace App\Services\FeedProcessors;

use App\Contracts\FeedProcessorInterface;
use SimpleXMLElement;
use App\Models\NewsItem;
use App\Services\NewsContentScrapers\LaIglesiaDeJesucristoScraper;
use Exception;

class LdsNewsFeedProcessor implements FeedProcessorInterface
{
    protected $country;
    protected $language;

    public function __construct(string $country, string $language)
    {
        $this->country = $country;
        $this->language = $language;
    }

    public function processFeed(string $feedUrl): void
    {
        try {
            $feed = simplexml_load_file($feedUrl);
            if (!$feed) throw new Exception("No se pudo cargar el feed: $feedUrl");
            $scraper = new LaIglesiaDeJesucristoScraper();

            foreach ($feed->channel->item as $item) {
                $link = (string) $item->link;
                if (NewsItem::where('link', $link)->exists()) continue;

                // Usando el scraper optimizado que realiza una única solicitud HTTP
                $scraper->prepare($link); // Preparar el scraper con la URL

                $content = $scraper->extractContent();
                $featuredImage = $scraper->extractFeaturedImage();
                $description = $scraper->extractDescription();
                $author = $scraper->extractAuthor();
                print_r($this->language);

                NewsItem::create([
                    'title' => trim((string) $item->title),
                    'description' => $description,
                    'link' => $link,
                    'pub_date' => (new \DateTime((string) $item->pubDate))->format('Y-m-d H:i:s'),
                    'author' => $author,
                    'source' => 'La Iglesia de Jesucristo - ' . $this->country,
                    'featured_image' => $featuredImage, 
                    'content' => $content,
                    'language' => $this->language
                ]);
            }
        } catch (Exception $e) {
            // Manejar error
        }
    }
}
