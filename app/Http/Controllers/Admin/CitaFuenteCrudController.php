<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CitaFuenteRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CitaFuenteCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CitaFuenteCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Citas\CitaFuente::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/cita-fuente');
        CRUD::setEntityNameStrings('cita fuente', 'cita fuentes');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('titulo')->type('text')->label('Título');
        CRUD::column('tipo_publicacion')->type('enum')->label('Tipo de Publicación');
        CRUD::column('fecha_publicacion')->type('text')->label('Fecha de Publicación');
        CRUD::column('isbn')->type('text')->label('ISBN');
        CRUD::column('url')->type('url')->label('URL');
        CRUD::column('nombre_revista')->type('text')->label('Nombre de la Revista');
        CRUD::column('numero_pagina')->type('number')->label('Número de Página');
        CRUD::column('ocasion')->type('text')->label('Ocasión');
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CitaFuenteRequest::class);

        CRUD::field('titulo')->type('text')->label('Título');
        CRUD::field('tipo_publicacion')->type('enum')->label('Tipo de Publicación');
        CRUD::field('fecha_publicacion')->type('text')->label('Fecha de Publicación');
        CRUD::field('isbn')->type('text')->label('ISBN');
        CRUD::field('url')->type('url')->label('URL');
        CRUD::field('nombre_revista')->type('text')->label('Nombre de la Revista');
        CRUD::field('numero_pagina')->type('number')->label('Número de Página');
        CRUD::field('ocasion')->type('text')->label('Ocasión');
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
