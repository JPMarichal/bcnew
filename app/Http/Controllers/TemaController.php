<?php

namespace App\Http\Controllers;

use App\Models\Tema;
use Illuminate\Http\Request;

class TemaController extends Controller
{
    public function show($id_tema)
    {
        $tema = Tema::with(['groupedThemes' => function ($query) {
            $query->orderBy('orden');
        }])->where('id', $id_tema)->firstOrFail();

        // Obtener los grupos únicos asociados con el tema principal
        $grupos = $tema->groupedThemes->unique('grupo_id')->sortBy('grupo_id');

        return view('temas.show', compact('tema', 'grupos'));
    }

    public function admin()
    {
        return view('temas.admin');
    }
}
