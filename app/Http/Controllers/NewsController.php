<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsPost;
use Carbon\Carbon;

class NewsController extends Controller
{
    public function index(Request $request, $month = null, $year = null)
    {
        $query = NewsPost::query();
        $month = $month ?: $request->query('month');
        $year = $year ?: $request->query('year', Carbon::now()->year);

        if ($month && $year) {
            $query->whereYear('pub_date', '=', $year)->whereMonth('pub_date', '=', $month);
        } elseif ($month) {
            $query->whereMonth('pub_date', '=', $month);
        }

        $news = $query->orderBy('pub_date', 'desc')->paginate(12);

        $years = NewsPost::selectRaw('YEAR(pub_date) as year')->groupBy('year')->orderBy('year', 'desc')->pluck('year')->all();

        // Preparar los meses por año para los filtros
        $monthsByYear = NewsPost::selectRaw('YEAR(pub_date) as year, MONTH(pub_date) as month')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get()
            ->groupBy('year')
            ->map(function ($items) {
                return $items->pluck('month');
            });

        return view('news.index', compact('news', 'years', 'monthsByYear'));
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

    public function search(Request $request)
    {
        $queryText = $request->input('query');
        // Escapar caracteres especiales para regex y preparar la expresión para buscar palabras completas
        $regex = preg_quote($queryText, '/');

        $news = NewsPost::query()
            ->whereRaw("title REGEXP '[[:<:]]" . $regex . "[[:>:]]'")
            ->orWhereRaw("description REGEXP '[[:<:]]" . $regex . "[[:>:]]'")
            ->orWhereRaw("content REGEXP '[[:<:]]" . $regex . "[[:>:]]'")
            ->orderBy('pub_date', 'desc')
            ->paginate(12);

        return view('news.index', compact('news'));
    }
}
