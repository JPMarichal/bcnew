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

    public function getLatestNews($cantidad = 5)
    {
        // Este método ahora encapsula la llamada a obtenerUltimasNoticias, que ya existe.
        // Retorna las últimas 5 noticias, pero puedes ajustar la cantidad según necesites.
        return $this->obtenerUltimasNoticias($cantidad);
    }
}
