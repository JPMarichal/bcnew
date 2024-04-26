<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\NewsService;
use Illuminate\Http\Response;

class NewsController extends Controller
{
    protected $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function index($cantidad = 5)
    {
        $noticias = $this->newsService->obtenerUltimasNoticias($cantidad);
        return response()->json($noticias);
    }
}
