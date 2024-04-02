<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('user', 'UserCrudController');
    Route::crud('newsitem', 'NewsitemCrudController');
    Route::crud('newspost', 'NewspostCrudController');
    Route::crud('escrituras/volumen', 'Escrituras\VolumenCrudController');
    Route::crud('escrituras/parte', 'Escrituras\ParteCrudController');
    Route::crud('escrituras/division', 'Escrituras\DivisionCrudController');
    Route::crud('escrituras/libro', 'Escrituras\LibroCrudController');
    Route::crud('escrituras/capitulo', 'Escrituras\CapituloCrudController');
    Route::crud('escrituras/pericopa', 'Escrituras\PericopaCrudController');
    Route::crud('escrituras/versiculo', 'Escrituras\VersiculoCrudController');
    Route::crud('escrituras/versiculocomentario', 'Escrituras\VersiculocomentarioCrudController');
    Route::crud('taxonomy', 'TaxonomyCrudController');
}); // this should be the absolute last line of this file