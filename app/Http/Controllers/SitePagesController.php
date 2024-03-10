<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SitePagesController extends Controller
{
    // Método para la página "Acerca de Nosotros"
    public function about()
    {
        return view('about');
    }
}
