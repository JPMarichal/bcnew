<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CitaService;
use Illuminate\Http\Response;

class CitaController extends Controller
{
    protected $citaService;

    public function __construct(CitaService $citaService)
    {
        $this->citaService = $citaService;
    }

    public function random()
    {
        $citaTexto = $this->citaService->obtenerCitaAleatoria();
        if (!$citaTexto) {
            return response("No se encontró una cita aleatoria.", 404)
                   ->header('Content-Type', 'text/plain');
        }

        return response($citaTexto, 200)
               ->header('Content-Type', 'text/plain');
    }
}
