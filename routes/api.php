<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Escrituras\VolumenController;
use App\Http\Controllers\Api\Escrituras\DivisionController;
use App\Http\Controllers\Api\Escrituras\LibroController;
use App\Http\Controllers\Api\Escrituras\ParteController;
use App\Http\Controllers\Api\Escrituras\CapituloController;
use App\Http\Controllers\Api\Escrituras\VersiculoController;
use App\Http\Controllers\Api\Escrituras\PasajeController;
use App\Http\Controllers\API\ImageUploadController;
use App\Http\Controllers\Api\CitaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('escrituras')->group(function () {
    Route::get('/volumenes', [VolumenController::class, 'index'])->name('volumenes.index');
    Route::get('/volumenes/{nombre}', [VolumenController::class, 'show'])->name('volumenes.show');
    Route::get('/divisiones', [DivisionController::class, 'index'])->name('divisiones.index');
    Route::get('/divisiones/{divisionId}', [DivisionController::class, 'show'])->name('divisiones.show');
    Route::get('/division/{divisionId}/libros', [DivisionController::class, 'librosPorDivision'])->name('division.libros');
    Route::get('/libros', [LibroController::class, 'index'])->name('libros.index');
    Route::get('/libro/{nombre}', [LibroController::class, 'show'])->name('libros.show');
    Route::get('/libro/{nombre}/partes', [LibroController::class, 'partesPorLibro'])->name('libros.partesPorLibro');
    Route::get('/libro/{nombre}/capitulos', [LibroController::class, 'capitulosPorLibro'])->name('libro.capitulos');
    Route::get('/capitulo/{referencia}', [CapituloController::class, 'show'])->name('capitulo.show');
    Route::get('/capitulo/{referencia}/pericopas', [CapituloController::class, 'pericopasPorCapitulo'])->name('capitulo.pericopas');
    Route::get('/capitulo/{referencia}/versiculos', [CapituloController::class, 'versiculosPorCapitulo'])->name('capitulo.versiculos');
    Route::get('/versiculo/{referencia}', [VersiculoController::class, 'show'])->name('versiculo.show');
    Route::get('/versiculo/{referencia}/social', [VersiculoController::class, 'social'])->name('versiculo.social');
    Route::get('/versiculo/{referencia}/comentarios', [VersiculoController::class, 'comentariosPorVersiculo'])->name('versiculo.comentarios');
    Route::get('/pasaje/{formato}/{referencia}/{titulo?}', [PasajeController::class, 'show'])->name('versiculo.show');
});

use App\Http\Controllers\OpenAIController;

Route::post('/openai/text-response', [OpenAIController::class, 'getTextResponse']);
Route::post('/openai/get-image', [OpenAIController::class, 'getImage']);
Route::post('/upload-image/{postId}', [ImageUploadController::class, 'upload'])->name('api.upload-image');

Route::get('/citas', [CitaController::class, 'index']);
Route::get('/citas/{id}', [CitaController::class, 'show']);
Route::get('/cita_aleatoria', [CitaController::class, 'random']);
