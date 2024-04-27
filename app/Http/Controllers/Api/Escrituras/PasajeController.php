<?php

namespace App\Http\Controllers\Api\Escrituras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PasajeService;
use App\Models\Escrituras\Pasaje;
use Barryvdh\Debugbar\Facade as Debugbar;

class PasajeController extends Controller
{
    protected $pasajeService;

    public function __construct(PasajeService $pasajeService)
    {
        $this->pasajeService = $pasajeService;
    }

    public function show(Request $request, $formato, $referencia, $titulo = null)
    {
        try {
            $respuesta = $this->pasajeService->obtenerPasajeFormateado($referencia, $formato, $titulo);

            // Ajusta el Content-Type de la respuesta según el formato solicitado.
            $contentType = $this->determinarContentType($formato);

            return response($respuesta, 200)
                ->header('Content-Type', $contentType);
        } catch (\Exception $e) {
            // Manejo de errores (por ejemplo, formato no soportado o referencia inválida)
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function random(){
        Debugbar::disable(); 

        $pasaje_obtenido = Pasaje::inRandomOrder()->first();
    
        $titulo = $pasaje_obtenido->titulo;
        $capitulo = $pasaje_obtenido->capitulo;
        $versiculo_inicial = $pasaje_obtenido->versiculo_inicial;
        $versiculo_final = $pasaje_obtenido->versiculo_final;
    
        return $titulo. "\n" . $capitulo->referencia. ":" . $versiculo_inicial. "-" . $versiculo_final;
    }

    /**
     * Determina el Content-Type de la respuesta basado en el formato solicitado.
     *
     * @param  string  $formato
     * @return string
     */
    protected function determinarContentType($formato)
    {
        switch ($formato) {
            case 'html':
                return 'text/plain';
            case 'texto':
                return 'text/plain';
            case 'json':
                return 'application/json';
            case 'ppt':
                return 'image/png';
            case 'png':
                return 'image/png';
            default:
                return 'text/plain';
        }
    }
}
