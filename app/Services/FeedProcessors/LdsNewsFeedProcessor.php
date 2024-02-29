<?php

namespace App\Services\FeedProcessors;

use App\Contracts\FeedProcessorInterface;
use SimpleXMLElement;
use App\Models\NewsItem;
use App\Services\NewsContentScrapers\LaIglesiaDeJesucristoScraper;
use Exception;
use DateTime;

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

            // Calcula la fecha de hace n días
            $dateLimit = new DateTime(env('DAYS2RETRIEVE'));

            foreach ($feed->channel->item as $item) {
                $link = (string) $item->link;
                if (NewsItem::where('link', $link)->exists()) continue;

                $publishedDate = DateTime::createFromFormat('Y-m-d', (string) $item->pubDate);

                if (!$publishedDate) {
                    continue;
                }

                // Verifica si la fecha de publicación es menor (más antigua) que el límite de 60 días.
                if ($publishedDate < $dateLimit) {
                    continue; // El ítem es más antiguo que 60 días, se salta.
                }

                // Usando el scraper optimizado que realiza una única solicitud HTTP
                $scraper->prepare($link); // Preparar el scraper con la URL

                $content = $scraper->extractContent();
                $featuredImage = $scraper->extractFeaturedImage();
                $description = $scraper->extractDescription();
                $author = $scraper->extractAuthor();

                NewsItem::create([
                    'title' => trim((string) $item->title),
                    'description' => $description,
                    'link' => $link,
                    'pub_date' => $publishedDate->format('Y-m-d H:i:s'),
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
