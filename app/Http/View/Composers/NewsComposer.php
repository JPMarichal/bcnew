<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\NewsPost;

class NewsComposer
{
    public function compose(View $view)
    {
        $years = NewsPost::selectRaw('YEAR(pub_date) as year')
                    ->groupBy('year')
                    ->orderBy('year', 'desc')
                    ->pluck('year');

        $view->with('years', $years);
    }
}
