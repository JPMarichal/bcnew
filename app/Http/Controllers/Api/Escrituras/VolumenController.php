<?php

namespace App\Http\Controllers\Api\Escrituras;

use App\Http\Controllers\Controller;
use App\Models\Escrituras\Volumen;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VolumenController extends Controller
{
    /**
     * Muestra una lista de todos los volúmenes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Recupera todos los volúmenes ordenados por id
        $volumenes = Volumen::orderBy('id')->get();

        // Devuelve los volúmenes en formato JSON
        return response()->json($volumenes);
    }

    /**
     * Muestra el volumen especificado por el nombre.
     *
     * @param  string  $nombre
     * @return \Illuminate\Http\Response
     */
    public function show($nombre)
    {
        // Intenta encontrar el volumen por su nombre, si no existe, devuelve un error 404
        $volumen = Volumen::where('nombre', $nombre)->firstOrFail();

        // Devuelve el volumen encontrado en formato JSON
        return response()->json($volumen);
    }
}
