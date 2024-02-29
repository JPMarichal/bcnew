<?php
namespace App\Services\NewsContentScrapers;

use App\Contracts\NewsContentScraperInterface;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class LaIglesiaDeJesucristoScraper implements NewsContentScraperInterface
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
        $content = $this->crawler->filter('#article-body')->first();
        return $content->count() > 0 ? trim($content->html()) : null;
    }

    public function extractFeaturedImage(): ?string
    {
        $image = $this->crawler->filter('meta[property="og:image"]')->first()->attr('content');
        if ($image && strpos($image, '/') === 0) {
            $image = 'http://newsroom.churchofjesuschrist.org' . $image;
        }
        return $image ?: 'http://imagen-por-defecto.jpg';
    }

    public function extractDescription(): ?string
    {
        $description = trim($this->crawler->filter('meta[property="og:description"]')->first()->attr('content'));
        return $description ?: '';
    }

    public function extractAuthor(): ?string
    {
      //  $author = $this->crawler->filter('meta[property="article:author"]')->first()->attr('content');
      //  return $author ?: 'Autor desconocido';
      return 'Newsroom';
    }
}
