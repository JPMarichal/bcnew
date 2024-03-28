<?php

namespace App\Http\Controllers\Api\Escrituras;

use App\Http\Controllers\Controller;
use App\Models\Escrituras\Versiculo;
use App\Models\Escrituras\Capitulo;
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

    /**
     * Devuelve el versículo especificado por la referencia en un formato apropiado
     * para compartir en redes sociales.
     *
     * @param  string  $referencia
     * @return \Illuminate\Http\Response
     */
    public function social($referencia)
    {
        $versiculo = Versiculo::where('referencia', $referencia)->firstOrFail();

        // Formatea el versículo y la referencia para compartir en redes sociales
        $textoParaCompartir = "\"{$versiculo->contenido}\" ({$versiculo->referencia})";

        // Devuelve el texto como respuesta de tipo texto plano
        return response($textoParaCompartir, 200)
            ->header('Content-Type', 'text/plain');
    }
}
