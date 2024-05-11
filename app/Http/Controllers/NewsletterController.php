<?php

namespace App\Http\Controllers;

use App\Services\CitaService;
use App\Services\NewsService;
use App\Services\PasajeService;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    protected $citaService;
    protected $newsService;
    protected $pasajeService;

    public function __construct(CitaService $citaService, NewsService $newsService, PasajeService $pasajeService)
    {
        $this->citaService = $citaService;
        $this->newsService = $newsService;
        $this->pasajeService = $pasajeService;
    }

    public function sendNewsletter()
    {
        $citas = $this->citaService->getDailyCita();
        $news = $this->newsService->getLatestNews();
        $pasajes = $this->pasajeService->getDailyPasaje();

        return view('boletin.newsletter', [
            'citas' => $citas,
            'news' => $news,
            'pasajes' => $pasajes,
        ])->render();  // Agrega render() para devolver la vista como string
    }
}
