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

    public function contact()
    {
        return view('contact');
    }

    public function sendContactEmail(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        \Mail::send('emails.contact', [
            'name' => $request->name,
            'email' => $request->email,
            'bodyMessage' => $request->message
        ], function ($message) {
            $message->from('noreply@biblicomentarios.com', 'Biblicomentarios Contact');
            $message->to('jpmarichal@gmail.com')->subject('Contacto desde Biblicomentarios');
        });

        return back()->with('success', 'Gracias por contactarnos. Pronto estaremos en comunicación contigo.');
    }

    public function cookiesPolicy()
    {
        return view('cookies-policy');
    }
}
