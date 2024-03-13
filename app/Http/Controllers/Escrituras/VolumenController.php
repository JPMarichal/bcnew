<?php

namespace App\Http\Controllers\Escrituras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Escrituras\Volumen;

class VolumenController extends Controller
{
    public function index()
    {
        $volumenes = Volumen::all();
        return view('escrituras.volumenes.index', compact('volumenes'));
    }

    public function show($nombre)
    {
        $volumen = Volumen::where('nombre', $nombre)->firstOrFail();
        return view('escrituras.volumenes.show', compact('volumen'));
    }
}
