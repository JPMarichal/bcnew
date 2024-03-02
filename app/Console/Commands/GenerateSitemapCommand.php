<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SitemapService;
use App\Strategies\Sitemap\NewsSitemapStrategy;

class GenerateSitemapCommand extends Command {
    protected $signature = 'sitemap:generate';
    protected $description = 'Generates the sitemap.xml file.';

    public function handle(SitemapService $sitemapService) {
        $sitemapService->registerStrategy(new NewsSitemapStrategy());
        $sitemapService->generateSitemap();

        $this->info('Sitemap generated successfully.');
    }
}
