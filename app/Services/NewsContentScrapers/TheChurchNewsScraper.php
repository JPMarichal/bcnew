<?php
namespace App\Services\NewsContentScrapers;

use App\Contracts\NewsContentScraperInterface;
use Goutte\Client;

class TheChurchNewsScraper implements NewsContentScraperInterface
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function extractContent(string $url): ?string
    {
        $crawler = $this->client->request('GET', $url);
        $content = $crawler->filter('.cn-article-body')->each(function ($node) {
            return $node->html();
        });

        return !empty($content) ? implode(" ", $content) : null;
    }

    public function extractFeaturedImage(string $url): ?string
    {
        $crawler = $this->client->request('GET', $url);
        $image = $crawler->filter('meta[property="og:image"]')->first()->attr('content');

        return $image ?: null;
    }

    public function extractDescription(string $url): ?string
    {
        $crawler = $this->client->request('GET', $url);
        $description = $crawler->filter('meta[property="og:description"]')->first()->attr('content');

        return $description ?: null;
    }

    public function extractAuthor(string $url): ?string
    {
        $crawler = $this->client->request('GET', $url);
        $author = $crawler->filter('meta[name="parsely-author"]')->first()->attr('content');

        return $author ?: null;
    }
}
