<?php
namespace App\Contracts;

interface NewsContentScraperInterface
{
    public function extractContent(string $url): ?string;
    public function extractFeaturedImage(string $url): ?string;
    public function extractDescription(string $url): ?string;
    public function extractAuthor(string $url): ?string;
}
