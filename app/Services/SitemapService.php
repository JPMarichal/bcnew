<?php
namespace App\Services;

use App\Contracts\SitemapGeneratorInterface;

class SitemapService {
    protected $strategies = [];

    public function registerStrategy(SitemapGeneratorInterface $strategy) {
        $this->strategies[] = $strategy;
    }

    public function generateSitemap() {
        // Inicia el índice del sitemap
        $sitemapIndex = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemapIndex .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        
        foreach ($this->strategies as $strategy) {
            // Aquí asumimos que cada estrategia devuelve las URLs de los sitemaps generados
            $sitemapUrls = explode(' ', $strategy->generate());
            foreach ($sitemapUrls as $sitemapUrl) {
                $sitemapIndex .= "<sitemap>";
                $sitemapIndex .= "<loc>{$sitemapUrl}</loc>";
                $sitemapIndex .= "<lastmod>" . now()->format('Y-m-d') . "</lastmod>";
                $sitemapIndex .= "</sitemap>";
            }
        }

        $sitemapIndex .= '</sitemapindex>';

        // Guardar el sitemap index
        file_put_contents(public_path('sitemap_index.xml'), $sitemapIndex);
    }
}
