<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsPost;
use Carbon\Carbon;

class NewsController extends Controller
{
    public function index(Request $request, $month = null, $year = null)
    {
        // Preparar la consulta base de noticias
        $query = NewsPost::query();

        // Intenta obtener mes y año de la URL o de los parámetros de consulta
        $month = $month ?: $request->query('month');
        $year = $year ?: $request->query('year', Carbon::now()->year); // Asegura que el año por defecto sea el actual

        if ($month && $year) {
            $query->whereYear('pub_date', '=', $year)
                ->whereMonth('pub_date', '=', $month);
        } elseif ($month) {
            $query->whereYear('pub_date', '=', $year) // Usa el año actual si solo se proporciona el mes
                ->whereMonth('pub_date', '=', $month);
        }

        $news = $query->orderBy('pub_date', 'desc')->paginate(12);

        // Ajusta aquí para obtener los años disponibles
        $years = NewsPost::selectRaw('YEAR(pub_date) as year')->groupBy('year')->orderBy('year', 'desc')->pluck('year');

        // Pasar los años y las noticias a la vista
        return view('news.index', compact('news', 'years'));
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
