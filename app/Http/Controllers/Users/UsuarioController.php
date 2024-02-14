<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    public function profile(){
        // Recupera el usuario actual 
        $user = auth()->user();
        $roles = $user->getRoleNames(); 
        // Retorna la vista de perfil del usuario actual con los datos del usuario recuperado
        return view('profile.userprofile', compact('user','roles'));
    }
}
