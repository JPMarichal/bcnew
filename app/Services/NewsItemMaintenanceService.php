<?php

namespace App\Services;
use App\Models\NewsItem;

class NewsItemMaintenanceService
{
    /**
     * Reduce el número de registros en la tabla `news_items` al límite especificado.
     *
     * @param int $limit Limite de registros permitidos.
     */
    public function maintainDatabase(int $limit = 1000): void
    {
        while (NewsItem::count() > $limit) {
            NewsItem::orderBy('pub_date', 'asc')->first()->delete();
        }
    }
}
