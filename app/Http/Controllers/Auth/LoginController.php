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

        // Comprobando si es el primer usuario (Administrador) o si necesita el rol Suscriptor
        // Verifica si el usuario fue recientemente creado o si no tiene roles asignados
        if ($user->wasRecentlyCreated || !$user->roles()->count()) {
            // Si el ID del usuario es 1, se le asignan los roles de Administrador y Suscriptor
            if ($user->id == 1) {
                $user->assignRole('Administrador');
                $user->assignRole('Suscriptor');
            } else {
                // Para cualquier otro usuario, se le asigna el rol de Suscriptor por defecto
                $user->assignRole('Suscriptor');
            }
        }

        Auth::login($user, true); // El segundo parámetro 'true' indica "recuérdame"

        return redirect()->route('dashboard');
    }

    public function login()
    {
        return view('auth.login'); // Redirige al usuario a la página principal o a donde prefieras
    }

    public function logout()
    {
        Auth::logout(); // Cierra la sesión del usuario actual

        return view('home'); // Redirige al usuario a la página principal o a donde prefieras
    }
}
