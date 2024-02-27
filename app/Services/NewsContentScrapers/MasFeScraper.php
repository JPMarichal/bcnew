<?php
namespace App\Services\NewsContentScrapers;

use App\Contracts\NewsContentScraperInterface;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class MasFeScraper implements NewsContentScraperInterface
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
        $content = $this->crawler->filter('.elementor-widget-container')->each(function ($node) {
            return $node->html();
        });

        return !empty($content) ? implode(" ", $content) : null;
    }

    public function extractFeaturedImage(): ?string
    {
        $image = $this->crawler->filter('meta[property="og:image"]')->first()->attr('content');

        return $image ?: null;
    }

    public function extractDescription(): ?string
    {
        $description = $this->crawler->filter('meta[property="og:description"]')->first()->attr('content');

        return $description ?: null;
    }

    public function extractAuthor(): ?string
    {
        $author = $this->crawler->filter('meta[name="author"]')->first()->attr('content');
        return $author ?: 'Autor desconocido';
    }
}
