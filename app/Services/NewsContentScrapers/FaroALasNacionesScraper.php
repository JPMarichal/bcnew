<?php

namespace App\Services\NewsContentScrapers;

use App\Contracts\NewsContentScraperInterface;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class FaroALasNacionesScraper implements NewsContentScraperInterface
{
    protected $client;
    protected $crawler;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function prepare(string $url): void
    {
        $this->crawler = $this->client->request('GET', $url);
    }

    public function extractContent(): ?string
    {
        if (!$this->crawler) return null;
        $content = $this->crawler->filter('.post-content')->each(function ($node) {
            return $node->html();
        });
        return !empty($content) ? implode(" ", $content) : null;
    }

    public function extractFeaturedImage(): ?string
    {
        if (!$this->crawler) return null;
        $image = $this->crawler->filter('meta[property="og:image"]')->first()->attr('content');
        return $image ?: 'http://imagen-por-defecto.jpg';
    }

    public function extractDescription(): ?string
    {
        if (!$this->crawler) return null;
        $description = $this->crawler->filter('meta[property="og:description"]')->first()->attr('content');
        return $description ?: '';
    }

    public function extractAuthor(): ?string
    {
        if (!$this->crawler) return 'Autor desconocido';
        // Ajustamos el selector para apuntar directamente al anchor (<a>) que tiene la clase 'post-author'
        $authorNode = $this->crawler->filter('a.post-author');
        // Verificamos si el nodo existe
        if ($authorNode->count() > 0) {
            $authorText = trim($authorNode->text());
            // Verificamos si el texto extraído, después de hacer trim, no está vacío
            if (!empty($authorText)) {
                return $authorText;
            }
        }
        return 'Autor desconocido';
    }
}
