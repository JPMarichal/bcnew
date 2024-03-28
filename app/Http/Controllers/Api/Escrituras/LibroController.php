<?php

namespace App\Http\Controllers\Api\Escrituras;

use App\Http\Controllers\Controller;
use App\Models\Escrituras\Libro;
use Illuminate\Http\Request;

class LibroController extends Controller
{
    /**
     * Muestra una lista de todos los libros.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $libros = Libro::orderBy('id')->get();
        return response()->json($libros);
    }

    /**
     * Muestra el libro especificado por el nombre.
     *
     * @param  string  $nombre
     * @return \Illuminate\Http\Response
     */
    public function show($nombre)
    {
        // Intenta encontrar el volumen por su nombre, si no existe, devuelve un error 404
        $volumen = Libro::where('nombre', $nombre)->firstOrFail();

        // Devuelve el volumen encontrado en formato JSON
        return response()->json($volumen);
    }

    /**
     * Muestra la lista de partes para un libro específico, ordenadas por el campo 'orden'.
     * 
     * @param  string  $nombre
     * @return \Illuminate\Http\Response
     */
    public function partesPorLibro($nombre)
    {
        $partes = Libro::where('nombre', $nombre)->firstOrFail()->partes()->orderBy('orden', 'asc')->get();
        return response()->json($partes);
    }

    /**
     * Muestra la lista de capítulos para un libro específico, ordenados por el campo 'num_capitulo'.
     * 
     * @param  string  $nombre
     * @return \Illuminate\Http\Response
     */
    public function capitulosPorLibro($nombre)
    {
        $partes = Libro::where('nombre', $nombre)->firstOrFail()->capitulos()->orderBy('num_capitulo', 'asc')->get();
        return response()->json($partes);
    }
}
