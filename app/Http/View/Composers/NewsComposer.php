<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\NewsPost;
use DB;

class NewsComposer
{
    public function compose(View $view)
    {
        $years = NewsPost::selectRaw('YEAR(pub_date) as year')
                    ->groupBy('year')
                    ->orderBy('year', 'desc')
                    ->pluck('year');

        // Nueva lógica para obtener meses disponibles por año
        $monthsByYear = NewsPost::selectRaw('YEAR(pub_date) as year, MONTH(pub_date) as month')
                        ->groupBy('year', 'month')
                        ->get()
                        ->groupBy('year')
                        ->map(function ($year) {
                            return $year->pluck('month');
                        });

        $view->with('years', $years)->with('monthsByYear', $monthsByYear);
    }
}
