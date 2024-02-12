<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'password' => Hash::make(Str::random(40)),
            ]
        );

        Auth::login($user, true); // El segundo parámetro 'true' indica "recuérdame"

        return view('welcome');
        //return redirect()->route('home'); // Asegúrate de tener una ruta definida para 'home'
    }

    public function logout()
    {
        Auth::logout(); // Cierra la sesión del usuario actual

        return redirect('/'); // Redirige al usuario a la página principal o a donde prefieras
    }
}
