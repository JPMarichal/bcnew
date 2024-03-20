<?php
namespace App\Http\Controllers\Escrituras;

use App\Models\Escrituras\Versiculo;
use App\Http\Controllers\Controller;
use App\Models\Escrituras\VersiculoComentario;

class VersiculoController extends Controller
{

    public function show($referencia)
    {
        $versiculo = Versiculo::where('referencia', $referencia)->firstOrFail();
        $comentarios = $versiculo->comentarios()->get();
        return view('escrituras.versiculos.comentarios.show', compact('versiculo', 'comentarios'));
    } 
    
    public function admin($referencia)
    {
        $versiculo = Versiculo::where('referencia', $referencia)->firstOrFail();
        $comentarios = $versiculo->comentarios()->get();
        return view('escrituras.versiculos.admin.comentarios', compact('versiculo', 'comentarios'));
    }
}
