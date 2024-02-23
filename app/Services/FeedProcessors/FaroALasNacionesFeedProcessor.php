<?php

namespace App\Services\FeedProcessors;

use App\Contracts\FeedProcessorInterface;
use SimpleXMLElement;
use App\Models\NewsItem;
use App\Services\NewsContentScrapers\FaroALasNacionesScraper; // Asegúrate de importar correctamente el scraper

class FaroALasNacionesFeedProcessor implements FeedProcessorInterface
{
    public function processFeed(string $feedUrl): void
    {
        $feed = simplexml_load_file($feedUrl);
        $scraper = new FaroALasNacionesScraper(); // Instancia el scraper

        foreach ($feed->channel->item as $item) {
            $link = (string) $item->link;
            $title = (string) $item->title;

            // Si no hay título, no se realiza ninguna extracción
            if (empty($title)) {
                continue;
            }

            if (!NewsItem::where('link', $link)->exists()) {
                // Utiliza el scraper para obtener los datos

                $content = trim($scraper->extractContent($link)); // Obtiene el contenido HTML mediante el scraper
                $author = '';
                $description = $scraper->extractDescription($link); // Obtiene la descripción mediante el scraper
                $featuredImage = $scraper->extractFeaturedImage($link); // Obtiene la imagen destacada mediante el scraper
                //    $author = $scraper->extractAuthor($link); // Obtiene el autor mediante el scraper
                $publishedDate = new \DateTime((string) $item->pubDate);

                NewsItem::create([
                    'title' => $title,
                    'description' => $description,
                    'link' => $link,
                    'pub_date' => $publishedDate->format('Y-m-d H:i:s'),
                    'author' => $author ?: 'Autor desconocido',
                    'source' => 'Faro a las Naciones',
                    'featured_image' => $featuredImage,
                    'content' => $content,
                    'language' => 'es'
                ]);
            }
        }
    }
}
