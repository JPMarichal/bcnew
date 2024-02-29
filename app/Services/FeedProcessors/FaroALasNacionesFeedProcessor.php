<?php
namespace App\Services\FeedProcessors;

use App\Contracts\FeedProcessorInterface;
use SimpleXMLElement;
use App\Models\NewsItem;
use App\Services\NewsContentScrapers\FaroALasNacionesScraper;
use DateTime;
use Illuminate\Support\Facades\Log;

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

        $dateLimit = new DateTime(env('DAYS2RETRIEVE'));

        foreach ($feed->channel->item as $item) {
            $link = (string) $item->link;
            if (empty($link) || NewsItem::where('link', $link)->exists()) {
                continue;
            }

            try {
                // Ajusta aquí el formato de fecha según el ejemplo proporcionado
                $publishedDate = DateTime::createFromFormat('D, d M Y H:i:s O', (string) $item->pubDate);

                if (!$publishedDate || $publishedDate < $dateLimit) {
                    continue; // El ítem es más antiguo que 30 días o la fecha no es válida, se salta.
                }

                $scraper->prepare($link); // Preparar el scraper con la URL

                $description = $scraper->extractDescription();
                $featuredImage = $scraper->extractFeaturedImage();
                $content = $scraper->extractContent();

                NewsItem::create([
                    'title' => trim((string) $item->title),
                    'description' => $description ?: 'Descripción no disponible',
                    'link' => $link,
                    'pub_date' => $publishedDate->format('Y-m-d H:i:s'),
                    'author' => '',
                    'source' => 'Faro a las Naciones',
                    'featured_image' => $featuredImage,
                    'content' => trim($content),
                    'language' => 'es',
                    'country' => 'Chile',
                ]);
            } catch (Exception $e) {
                // Considerar agregar un manejo de excepción o log aquí
            }
        }
    }
}
