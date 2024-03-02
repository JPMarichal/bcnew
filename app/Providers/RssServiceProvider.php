<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Services\RssGenerators\NewsRssGenerator;

class RssServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Route::get('/rss/noticias', function (NewsRssGenerator $newsRssGenerator) {
            $rssContent = $newsRssGenerator->generate();
            return response($rssContent, 200, ['Content-Type' => 'application/rss+xml; charset=utf-8']);
        });
    }
}
