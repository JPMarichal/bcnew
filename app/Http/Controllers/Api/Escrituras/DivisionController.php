<?php

namespace App\Http\Controllers\Api\Escrituras;

use App\Http\Controllers\Controller;
use App\Models\Escrituras\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    /**
     * Muestra una lista de todas las divisiones.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisiones = Division::orderBy('id')->get();
        return response()->json($divisiones);
    }

    /**
     * Muestra una división específica.
     * 
     * @param  int  $divisionId
     * @return \Illuminate\Http\Response
     */
    public function show($divisionId)
    {
        $division = Division::where('id', $divisionId)->firstOrFail();
        return response()->json($division);
    }
    /**
     * Muestra la lista de libros para una división específica, ordenados por ID.
     * 
     * @param  int  $divisionId
     * @return \Illuminate\Http\Response
     */
    public function librosPorDivision($divisionId)
    {
        $libros = Division::findOrFail($divisionId)->libros()->orderBy('id')->get();
        return response()->json($libros);
    }
}
