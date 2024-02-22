<?php

namespace App\Services\NewsContentScrapers;

use App\Contracts\NewsContentScraperInterface;
use Goutte\Client;

class LaIglesiaDeJesucristoScraper implements NewsContentScraperInterface
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function extractContent(string $url): ?string
    {
        $crawler = $this->client->request('GET', $url);
        $content = $crawler->filter('#article-body')->first();

        return $content->count() > 0 ? trim($content->html()) : null;
    }

    public function extractFeaturedImage(string $url): ?string
    {
        $crawler = $this->client->request('GET', $url);
        $image = $crawler->filter('meta[property="og:image"]')->first()->attr('content');

        // Verifica si la URL de la imagen comienza con "/"
        if ($image && strpos($image, '/') === 0) {
            // Antepone el protocolo y dominio a la URL truncada
            $image = 'http://newsroom.churchofjesuschrist.org' . $image;
        }

        // Si no se encontró imagen o no existe el atributo content, usa una imagen por defecto
        if (!$image) {
            $image = 'http://imagen-por-defecto.jpg'; // URL de la imagen por defecto
        }

        return $image;
    }

    public function extractDescription(string $url): ?string
    {
        $crawler = $this->client->request('GET', $url);
        // Intenta obtener el contenido del tag meta property="og:description"
        $description = trim($crawler->filter('meta[property="og:description"]')->first()->attr('content'));

        // Si no se encuentra la descripción, puedes optar por retornar un valor por defecto o null
        return $description ? $description : '';
    }

    public function extractAuthor(string $url): ?string
    {
        $crawler = $this->client->request('GET', $url);
        // Intenta obtener el contenido del tag meta property="article:author"
        $author = $crawler->filter('meta[property="article:author"]')->first()->attr('content');

        // Si no se encuentra el autor, puedes optar por retornar un valor por defecto o null
        return $author ? $author : null;
    }

    protected function scrape(string $url, string $selector, string $attribute = null): ?string
    {
        $crawler = $this->client->request('GET', $url);
        if ($attribute) {
            return $crawler->filter($selector)->attr($attribute);
        }
        return $crawler->filter($selector)->text();
    }
}
