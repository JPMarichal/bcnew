<?php
namespace App\Services\NewsContentScrapers;

use App\Contracts\NewsContentScraperInterface;
use Goutte\Client;

class MasFeScraper implements NewsContentScraperInterface
{
    public function extractContent(string $url): ?string
    {
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $content = $crawler->filter('.elementor-widget-container')->each(function ($node) {
            return $node->html();
        });

        return !empty($content) ? implode(" ", $content) : null;
    }

    public function extractFeaturedImage(string $url): ?string
    {
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $image = $crawler->filter('meta[property="og:image"]')->first()->attr('content');

        return $image ?: null;
    }

    public function extractDescription(string $url): ?string
    {
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $description = $crawler->filter('meta[property="og:description"]')->first()->attr('content');

        return $description ?: null;
    }

    public function extractAuthor(string $url): ?string
    {
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $author = $crawler->filter('meta[name="author"]')->first()->attr('content');
        return $author ?: 'Autor desconocido';
    }
}
