<?php
namespace App\Strategies\Sitemap;

use App\Contracts\SitemapGeneratorInterface;
use App\Models\NewsPost;
use Carbon\Carbon;

class NewsSitemapStrategy implements SitemapGeneratorInterface {
    public function generate(): string {
        $months = NewsPost::selectRaw('YEAR(pub_date) as year, MONTH(pub_date) as month')
                          ->distinct()
                          ->orderBy('year', 'desc')
                          ->orderBy('month', 'desc')
                          ->get();

        $sitemaps = [];

        foreach ($months as $month) {
            $yearMonth = Carbon::create($month->year, $month->month)->format('Y-m');
            $fileName = "sitemap-news-{$yearMonth}.xml";
            $filePath = public_path("sitemaps/{$fileName}");

            $newsItems = NewsPost::whereYear('pub_date', $month->year)
                                 ->whereMonth('pub_date', $month->month)
                                 ->get();

            $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
            $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

            foreach ($newsItems as $newsItem) {
                $pubDate = Carbon::parse($newsItem->pub_date)->toAtomString();
                $sitemap .= "<url>";
                $sitemap .= "<loc>" . route('noticias.show', $newsItem->slug) . "</loc>";
                $sitemap .= "<lastmod>{$pubDate}</lastmod>";
                $sitemap .= "</url>";
            }

            $sitemap .= '</urlset>';

            // Asegúrate de que el directorio existe
            if (!file_exists(public_path('sitemaps'))) {
                mkdir(public_path('sitemaps'), 0755, true);
            }

            // Guardar el sitemap en un archivo
            file_put_contents($filePath, $sitemap);

            $sitemaps[] = asset("sitemaps/{$fileName}");
        }

        return implode(' ', $sitemaps);
    }
}
