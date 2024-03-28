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

    public function pasaje_social($referencia)
    {
        // Mapeo de nombres para traducir nombres de libros a su nombre canónico
        $mapeoNombres = [
            'dyc' => 'Secciones',
            'doctrina y convenios' => 'Secciones',
            'dyC' => 'Secciones',
        ];

        // Función de mapeo para traducir nombres de libros usando el mapeo
        $traducirNombreLibro = function ($nombreLibro) use ($mapeoNombres) {
            $nombreLibro = strtolower($nombreLibro); // Convierte a minúsculas para la búsqueda
            return $mapeoNombres[$nombreLibro] ?? $nombreLibro;
        };

        preg_match('/^(.*?)(\d+:\d+(-\d+)?$)/', $referencia, $matches);
        $nombreLibro = trim($matches[1]);
        $nombreLibroTraducido = $traducirNombreLibro($nombreLibro);
        [$capitulo, $versiculoRango] = explode(':', $matches[2]);
        [$versiculoInicio, $versiculoFin] = explode('-', $versiculoRango) + [1 => null];

        $versiculoFin = $versiculoFin ?? $versiculoInicio;

        $versiculos = \App\Models\Escrituras\Versiculo::whereHas('capitulo', function ($query) use ($nombreLibroTraducido, $capitulo) {
            $query->whereHas('libro', function ($query) use ($nombreLibroTraducido) {
                $query->where('nombre', '=', $nombreLibroTraducido); // Utiliza el nombre traducido
            })->where('num_capitulo', '=', $capitulo);
        })
            ->whereBetween('num_versiculo', [$versiculoInicio, $versiculoFin])
            ->orderBy('num_versiculo', 'asc')
            ->get();

        if ($versiculos->isEmpty()) {
            return response("No hay resultados para esa referencia.", 200)
                ->header('Content-Type', 'text/plain');
        }

        // Ajusta el versículo final basado en los versículos disponibles
        $versiculoFinalReal = $versiculos->last()->num_versiculo;

        // Formatea el pasaje
        $textoParaCompartir = $versiculos->reduce(function ($carry, $versiculo) {
            return $carry .= "{$versiculo->num_versiculo} {$versiculo->contenido}\n";
        }, '');

        // Determina el nombre a mostrar en la referencia final
        $nombreLibroMostrar = array_search($nombreLibroTraducido, array_map(function ($key) use ($mapeoNombres) {
            return $mapeoNombres[$key];
        }, array_keys($mapeoNombres)), true) ?: $nombreLibro;

        $nombreLibroMostrar = $nombreLibroMostrar === 'Secciones' ? 'DyC' : $nombreLibro;

        $textoParaCompartir .= "({$nombreLibroMostrar} {$capitulo}:{$versiculoInicio}–{$versiculoFinalReal})";

        return response(rtrim($textoParaCompartir), 200)
            ->header('Content-Type', 'text/plain');
    }
}
