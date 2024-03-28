<?php

namespace App\Http\Controllers\Api\Escrituras;

use App\Http\Controllers\Controller;
use App\Models\Escrituras\Capitulo;
use Illuminate\Http\Request;

class CapituloController extends Controller
{
    /**
     * Muestra el capítulo especificado por la referencia.
     *
     * @param  string  $referencia
     * @return \Illuminate\Http\Response
     */
    public function show($referencia)
    {
        $capitulo = Capitulo::where('referencia', $referencia)->firstOrFail();
        return response()->json($capitulo);
    }

    /**
     * Muestra la lista de perícopas para un capítulo específico, ordenadas por el versículo inicial.
     * 
     * @param  string  $referencia
     * @return \Illuminate\Http\Response
     */
    public function pericopasPorCapitulo($referencia)
    {
        $pericopas = Capitulo::where('referencia', $referencia)->firstOrFail()
                             ->pericopas()->orderBy('versiculo_inicial', 'asc')->get();
        return response()->json($pericopas);
    }

    /**
     * Muestra la lista de versículos para un capítulo específico, ordenados por número de versículo.
     * 
     * @param  string  $referencia
     * @return \Illuminate\Http\Response
     */
    public function versiculosPorCapitulo($referencia)
    {
        $versiculos = Capitulo::where('referencia', $referencia)->firstOrFail()
                              ->versiculos()->orderBy('num_versiculo', 'asc')->get();
        return response()->json($versiculos);
    }
}
