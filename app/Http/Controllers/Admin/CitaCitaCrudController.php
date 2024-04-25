<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CitaCitaRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CitaCitaCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CitaCitaCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Citas\CitaCita::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/cita-cita');
        CRUD::setEntityNameStrings('cita cita', 'cita citas');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('texto')->label('Texto');
        CRUD::column('titulo')->label('Título');
        CRUD::column('autor_id')->label('Autor')->type('select')->entity('autor')->attribute('nombre')->model("App\Models\Citas\CitaAutor");
        CRUD::column('fuente_id')->label('Fuente')->type('select')->entity('fuente')->attribute('titulo')->model("App\Models\Citas\CitaFuente");
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CitaCitaRequest::class);

        CRUD::field('texto')->type('textarea')->label('Texto de la Cita');
        CRUD::field('titulo')->type('text')->label('Título de la Cita');
        CRUD::field('autor_id')->label('Autor')->type('select')->entity('autor')->attribute('nombre')->model("App\Models\Citas\CitaAutor");
        CRUD::field('fuente_id')->label('Fuente')->type('select')->entity('fuente')->attribute('titulo')->model("App\Models\Citas\CitaFuente");
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
