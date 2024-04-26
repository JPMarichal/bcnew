<?php

namespace App\Services;

use App\Models\NewsPost;

class NewsService
{
    public function obtenerUltimasNoticias($cantidad = 5)
    {
        return NewsPost::where('language', 'es')
                       ->orderBy('pub_date', 'desc')
                       ->take($cantidad)
                       ->get(['title', 'description', 'pub_date', 'featured_image', 'slug']);
    }
}
