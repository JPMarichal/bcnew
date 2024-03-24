<?php

namespace App\Http\Controllers\Escrituras;

use App\Http\Controllers\Controller;
use App\Models\Escrituras\Capitulo;
use Illuminate\Http\Request;

class CapituloController extends Controller
{
    /**
     * Muestra la lista de capítulos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Aquí puedes añadir lógica para mostrar todos los capítulos, si es necesario.
    }

    /**
     * Muestra el detalle de un capítulo específico basado en su nombre de referencia.
     *
     * @param  string  $referencia
     * @return \Illuminate\Http\Response
     */
    public function show($referencia)
    {
        $capituloActual = Capitulo::where('referencia', $referencia)->firstOrFail();

        // Encontrar el capítulo anterior, si no hay, seleccionar el último de todos los capítulos
        $capituloAnterior = Capitulo::where('id', '<', $capituloActual->id)
                                    ->orderBy('id', 'desc')
                                    ->first() ?? Capitulo::orderBy('id', 'desc')->first();

        // Encontrar el capítulo siguiente, si no hay, seleccionar el primero de todos los capítulos
        $capituloSiguiente = Capitulo::where('id', '>', $capituloActual->id)
                                      ->orderBy('id', 'asc')
                                      ->first() ?? Capitulo::orderBy('id', 'asc')->first();

        return view('escrituras.capitulos.show', [
            'capitulo' => $capituloActual,
            'capituloAnterior' => $capituloAnterior,
            'capituloSiguiente' => $capituloSiguiente,
        ]);
    }

    public function showComentarios($referencia)
    {
        $capituloActual = Capitulo::where('referencia', $referencia)->firstOrFail();

        // Encontrar el capítulo anterior, si no hay, seleccionar el último de todos los capítulos
        $capituloAnterior = Capitulo::where('id', '<', $capituloActual->id)
                                    ->orderBy('id', 'desc')
                                    ->first() ?? Capitulo::orderBy('id', 'desc')->first();

        // Encontrar el capítulo siguiente, si no hay, seleccionar el primero de todos los capítulos
        $capituloSiguiente = Capitulo::where('id', '>', $capituloActual->id)
                                      ->orderBy('id', 'asc')
                                      ->first() ?? Capitulo::orderBy('id', 'asc')->first();

        return view('escrituras.capitulos.comentarios', [
            'capitulo' => $capituloActual,
            'capituloAnterior' => $capituloAnterior,
            'capituloSiguiente' => $capituloSiguiente,
        ]);
    }
}
