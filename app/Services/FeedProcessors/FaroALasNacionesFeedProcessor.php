<?php

namespace App\Services\FeedProcessors;

use App\Contracts\FeedProcessorInterface;
use SimpleXMLElement;
use App\Models\NewsItem;
use App\Services\NewsContentScrapers\FaroALasNacionesScraper;
use Exception;
use DateTime;

class FaroALasNacionesFeedProcessor implements FeedProcessorInterface
{
    public function processFeed(string $feedUrl): void
    {
        $feed = simplexml_load_file($feedUrl);
        if (!$feed) {
            // Considerar agregar un log de error aquí
            return;
        }

        $scraper = new FaroALasNacionesScraper();

        // Calcula la fecha de hace n días
        $dateLimit = new DateTime('-30 days');

        foreach ($feed->channel->item as $item) {
            $link = (string) $item->link;
            if (empty($link) || NewsItem::where('link', $link)->exists()) {
              //  print_r('Abortado');
                continue;
            }

            try {
                //    print_r('========================================='."\n");
                //    print_r('Procesando: ' . $link . "\n");               

                $publishedDate = DateTime::createFromFormat('Y-m-d', (string) $item->pubDate);

                if (!$publishedDate) {
                    continue;
                }

                // Verifica si la fecha de publicación es menor (más antigua) que el límite de 60 días.
                if ($publishedDate < $dateLimit) {
                    continue; // El ítem es más antiguo que 60 días, se salta.
                }

                $scraper->prepare($link); // Preparar el scraper con la URL
                //    print_r('Scraper preparado' . "\n");

                $description = $scraper->extractDescription();
                //   print_r('Descripción: ' . $description . "\n");

                //  $author = $scraper->extractAuthor();
                //     print_r('Autor: ' . $author . "\n");

                $featuredImage = $scraper->extractFeaturedImage();
                // print_r('Imagen: ' . $featuredImage . "\n");

                $content = $scraper->extractContent();
                //  print_r('Contenido: '. $content. "\n");

                NewsItem::create([
                    'title' => trim((string) $item->title),
                    'description' => $description ?: 'Descripción no disponible',
                    'link' => $link,
                    'pub_date' => (new \DateTime((string) $item->pubDate))->format('Y-m-d H:i:s'),
                    'author' => '',
                    'source' => 'Faro a las Naciones',
                    'featured_image' => $featuredImage,
                    'content' => trim($content),
                    'language' => 'es',
                ]);
            } catch (Exception $e) {
                // Considerar agregar un manejo de excepción o log aquí
            }
        }
    }
}
