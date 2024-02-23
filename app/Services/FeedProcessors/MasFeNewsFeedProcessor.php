<?php

namespace App\Services\FeedProcessors;

use App\Contracts\FeedProcessorInterface;
use SimpleXMLElement;
use App\Models\NewsItem;
use App\Services\NewsContentScrapers\MasFeScraper; // Asegúrate de importar correctamente el scraper

class MasFeNewsFeedProcessor implements FeedProcessorInterface
{
    public function processFeed(string $feedUrl): void
    {
        $feed = simplexml_load_file($feedUrl);
        $scraper = new MasFeScraper(); // Instancia el scraper

        foreach ($feed->channel->item as $item) {
            $link = (string) $item->link;
            $title = (string) $item->title;

            // Si no hay título, no se realiza ninguna extracción
            if (empty($title)) {
                continue;
            }

            if (!NewsItem::where('link', $link)->exists()) {
                // Utiliza el scraper para obtener los datos
                $description = $scraper->extractDescription($link); // Obtiene la descripción mediante el scraper
                //   $content = $scraper->extractContent($link); // Obtiene el contenido HTML mediante el scraper
                $featuredImage = $scraper->extractFeaturedImage($link); // Obtiene la imagen destacada mediante el scraper
                $author = $scraper->extractAuthor($link); // Obtiene el autor mediante el scraper
                $publishedDate = new \DateTime((string) $item->pubDate);

                $content = (string) $item->children('http://purl.org/rss/1.0/modules/content/')->encoded;

                NewsItem::create([
                    'title' => $title,
                    'description' => $description ?: $description, // Usa la descripción extraída o la del feed si es necesario
                    'link' => $link,
                    'pub_date' => $publishedDate->format('Y-m-d H:i:s'),
                    'author' => $author ?: 'Autor desconocido',
                    'source' => 'Más Fe',
                    'featured_image' => $featuredImage ?: '', // Usa la imagen extraída
                    'content' => $content ?: $content, // Usa el contenido HTML extraído
                    'language' => 'es'
                ]);
            }
        }
    }
}
