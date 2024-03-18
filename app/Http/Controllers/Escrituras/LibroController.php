<?php

namespace App\Http\Controllers\Escrituras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Escrituras\Libro;

class LibroController extends Controller
{
    public function show($nombre)
    {
        $libro = Libro::where('nombre', $nombre)->firstOrFail();
        return view('escrituras.libros.show', compact('libro'));
    }
}
