<?php

namespace App\Http\Controllers\Escrituras;

use App\Http\Controllers\Controller;

class ParteController extends Controller
{
    /**
     * Muestra la vista de administración de partes.
     *
     * @return \Illuminate\View\View
     */
    public function admin()
    {
        return view('escrituras.partes.admin');
    }
}
