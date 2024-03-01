<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\NewsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/auth/google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback'])->name('auth.google.callback');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

require __DIR__.'/auth.php';

// Grupo de rutas para noticias
Route::prefix('noticias')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('noticias.index');
    Route::get('/pag{page}', [NewsController::class, 'index'])->where('page', '[0-9]+');
    Route::get('/{month}/{year}', [NewsController::class, 'index'])->where(['month' => '\d{2}', 'year' => '\d{4}']);
    Route::get('/{month}', [NewsController::class, 'index'])->where('month', '\d{2}');
    // Ruta unificada para mostrar noticias por slug o id
    Route::get('/{slugOrId}', [NewsController::class, 'show'])->name('noticias.show')->where('slugOrId', '^[a-z0-9-]+(?:\/[0-9]+)?$');
});
