<?php

namespace App\Http\Controllers\Api\Escrituras;

use App\Http\Controllers\Controller;
use App\Models\Escrituras\Versiculo;
use Illuminate\Http\Request;

class VersiculoController extends Controller
{
    /**
     * Muestra el versículo especificado por la referencia.
     *
     * @param  string  $referencia
     * @return \Illuminate\Http\Response
     */
    public function show($referencia)
    {
        $versiculo = Versiculo::where('referencia', $referencia)->firstOrFail();
        return response()->json($versiculo);
    }

    /**
     * Muestra la lista de comentarios para un versículo específico, ordenados por el campo 'orden'.
     * 
     * @param  string  $referencia
     * @return \Illuminate\Http\Response
     */
    public function comentariosPorVersiculo($referencia)
    {
        $comentarios = Versiculo::where('referencia', $referencia)->firstOrFail()
                                ->comentarios()->orderBy('orden', 'asc')->get();
        return response()->json($comentarios);
    }
}
