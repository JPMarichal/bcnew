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
        return Socialite::driver('google')
        ->with(['prompt' => 'select_account'])
        ->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $avatarUrl = $googleUser->user['picture'] ?? null;

      //  dd($googleUser);
     //  dd($avatarUrl);

        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'avatar' => $avatarUrl,
                'password' => Hash::make(Str::random(40)),
                'given_name' => $googleUser->user['given_name'] ?? null,
                'last_name' => $googleUser->user['family_name'] ?? null,
            ]
        );

        Auth::login($user, true); // El segundo parámetro 'true' indica "recuérdame"

        return view('auth.logout');
        //return redirect()->route('home'); // Asegúrate de tener una ruta definida para 'home'
    }

    public function login()
    {
        return view('auth.login'); // Redirige al usuario a la página principal o a donde prefieras
    }

    public function logout()
    {
        Auth::logout(); // Cierra la sesión del usuario actual

        return view('auth.login'); // Redirige al usuario a la página principal o a donde prefieras
    }
}
