<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
public function redirectToGoogle()
{
    return Socialite::driver('google')->redirect();
}

public function handleGoogleCallback()
{
    $user = Socialite::driver('google')->user();

    // Aquí puedes implementar tu lógica para registrar o iniciar sesión al usuario
    // Por ejemplo, verificar si el usuario ya existe y crearlo si no es así

    return view('welcome');
   // return redirect()->route('welcome'); // Redirige a donde necesites
}

}
