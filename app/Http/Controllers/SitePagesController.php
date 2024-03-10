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

    public function privacyPolicy()
    {
        return view('privacy-policy'); // Asegúrate de que el nombre de la vista corresponda al archivo real en tu proyecto.
    }
}
