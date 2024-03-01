<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsPost;
use Carbon\Carbon;

class NewsController extends Controller
{
    public function index(Request $request, $month = null, $year = null)
    {
        if ($month && $year) {
            // Filtrar noticias por mes y año específicos
            $news = NewsPost::whereYear('pub_date', '=', $year)
                            ->whereMonth('pub_date', '=', $month)
                            ->paginate(10);
        } elseif ($month) {
            // Filtrar noticias por mes del año actual
            $year = Carbon::now()->year;
            $news = NewsPost::whereYear('pub_date', '=', $year)
                            ->whereMonth('pub_date', '=', $month)
                            ->paginate(10);
        } else {
            // Mostrar todas las noticias o una página específica
            $news = NewsPost::paginate(10);
        }

        return view('news.index', compact('news'));
    }

    public function show($slugOrId)
    {
        // Determinar si el parámetro es un slug o un ID numérico
        if (is_numeric($slugOrId)) {
            $newsItem = NewsPost::findOrFail($slugOrId);
        } else {
            $newsItem = NewsPost::where('slug', $slugOrId)->firstOrFail();
        }

        return view('news.show', compact('newsItem'));
    }
}
