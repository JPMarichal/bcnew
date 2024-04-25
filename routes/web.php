<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ErrorTestController;
use App\Http\Controllers\SitePagesController;
use App\Http\Controllers\Escrituras\VolumenController;
use App\Http\Controllers\Escrituras\LibroController;
use App\Http\Controllers\Escrituras\ParteController;
use App\Http\Controllers\Escrituras\CapituloController;
use App\Http\Controllers\Escrituras\VersiculoController;
use App\Http\Controllers\Blog\BlogController;

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
})->name('home');

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

require __DIR__ . '/auth.php';

// Grupo de rutas para pruebas de errores HTTP
Route::prefix('test-errors')->group(function () {
    Route::get('/400', [ErrorTestController::class, 'badRequest'])->name('test.400');
    Route::get('/401', [ErrorTestController::class, 'unauthorized'])->name('test.401');
    Route::get('/403', [ErrorTestController::class, 'forbidden'])->name('test.403');
    Route::get('/404', [ErrorTestController::class, 'notFound'])->name('test.404');
    Route::get('/405', [ErrorTestController::class, 'methodNotAllowed'])->name('test.405');
    Route::get('/408', [ErrorTestController::class, 'requestTimeout'])->name('test.408');
    Route::get('/429', [ErrorTestController::class, 'tooManyRequests'])->name('test.429');
    Route::get('/500', [ErrorTestController::class, 'internalServerError'])->name('test.500');
    Route::get('/501', [ErrorTestController::class, 'notImplemented'])->name('test.501');
    Route::get('/502', [ErrorTestController::class, 'badGateway'])->name('test.502');
    Route::get('/503', [ErrorTestController::class, 'serviceUnavailable'])->name('test.503');
    Route::get('/504', [ErrorTestController::class, 'gatewayTimeout'])->name('test.504');
    Route::get('/505', [ErrorTestController::class, 'genericError'])->name('test.generic');
});

// Grupo de rutas para las páginas del sitio
Route::group(['prefix' => 'site'], function () {
    Route::get('about', [SitePagesController::class, 'about'])->name('site.about');
    Route::get('privacy-policy', [SitePagesController::class, 'privacyPolicy'])->name('site.privacy-policy');
    Route::get('cookies-policy', [SitePagesController::class, 'cookiesPolicy'])->name('site.cookies-policy');
    Route::get('contact', [SitePagesController::class, 'contact'])->name('site.contact');
    Route::post('contact', [SitePagesController::class, 'sendContactEmail'])->name('site.sendContactEmail');
});

// Grupo de rutas para noticias
Route::prefix('noticias')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('noticias.index');
    Route::get('/pag{page}', [NewsController::class, 'index'])->where('page', '[0-9]+');
    Route::get('/{month}/{year}', [NewsController::class, 'index'])->where(['month' => '\d{2}', 'year' => '\d{4}']);
    Route::get('/{month}', [NewsController::class, 'index'])->where('month', '\d{2}');
    Route::get('/buscar', [NewsController::class, 'search'])->name('noticias.search');

    // Ruta unificada para mostrar noticias por slug o id
    Route::get('/{slugOrId}', [NewsController::class, 'show'])->name('noticias.show')->where('slugOrId', '^[a-z0-9-]+(?:\/[0-9]+)?$');
});

Route::prefix('escrituras')->group(function () {
    Route::get('/volumenes', [VolumenController::class, 'index'])->name('volumenes.index');
    Route::get('/volumen/{nombre}', [VolumenController::class, 'show'])->name('volumenes.show');
    Route::get('/libros', [LibroController::class, 'index'])->name('libros.index');
    Route::get('/libro/{nombre}', [LibroController::class, 'show'])->name('libros.show');
    Route::get('/partes/admin', [ParteController::class, 'admin'])->name('partes.admin');
    Route::get('/capitulos', [CapituloController::class, 'index'])->name('capitulos.index');
    Route::get('/capitulo/{nombre}', [CapituloController::class, 'show'])->name('capitulos.show');
    Route::get('/capitulo/{nombre}/comentarios', [CapituloController::class, 'showComentarios'])->name('capitulos.comentarios');
    Route::get('/versiculo/{referencia}/comentarios', [VersiculoController::class, 'show'])->name('versiculos.comentarios');
    Route::get('/versiculo/{referencia}/comentarios/admin', [VersiculoController::class, 'admin'])->name('versiculos.comentarios.admin');
});

// Grupo de rutas para taxonomías con un prefijo común
Route::prefix('taxonomies')->group(function () {
    Route::get('/', function () {
        return view('taxonomies.index');
    })->name('taxonomies.index');

    Route::get('/manage/{taxonomyId?}', function ($taxonomyId = null) {
        return view('taxonomies.manage', compact('taxonomyId'));
    })->name('taxonomies.manage');


    Route::get('/terms/{taxonomyId?}', function ($taxonomyId = null) {
        return view('taxonomies.terms', compact('taxonomyId'));
    })->name('taxonomies.terms');
});

// Grupo de rutas para el blog
Route::prefix('blog')->name('blog.')->middleware(['internalLinks'])->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/{slug}', [BlogController::class, 'show'])->name('show');


    //  
});

Route::get('/celebracion', [BlogController::class, 'celebracion'])->name('celebracion');

// Filtradas de acuerdo a una característica específica 
Route::get('/sinthumbnail', [BlogController::class, 'sinThumbnail'])->name('sin_thumbnail');
