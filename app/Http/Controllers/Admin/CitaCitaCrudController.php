<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CitaCitaRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class CitaCitaCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Citas\CitaCita::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/cita-cita');
        CRUD::setEntityNameStrings('cita cita', 'cita citas');
    }

    protected function setupListOperation()
    {
        CRUD::column('titulo')->label('Título');
        CRUD::column('texto')->label('Texto');
        CRUD::column('autor_id')->label('Autor')->type('select')->entity('autor')->attribute('nombre')->model("App\Models\Citas\CitaAutor");
        CRUD::column('fuente_id')->label('Fuente')->type('select')->entity('fuente')->attribute('titulo')->model("App\Models\Citas\CitaFuente");
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(CitaCitaRequest::class);
        CRUD::field('titulo')->type('text')->label('Título de la Cita');
        CRUD::field('texto')->type('textarea')->label('Texto de la Cita');
        CRUD::field('autor_id')->label('Autor')->type('select')->entity('autor')->attribute('nombre')->model("App\Models\Citas\CitaAutor");
        CRUD::field('fuente_id')->label('Fuente')->type('select')->entity('fuente')->attribute('titulo')->model("App\Models\Citas\CitaFuente");
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false); // Desactivar la configuración automática

        // Configuración de la columna de título
        CRUD::column('titulo')->label('Título')
            ->type('text') // Asegura que se muestre como texto simple
            ->escaped(false) // Asegura que el HTML no sea escapado si es necesario
            ->limit(100000); // Establece un límite alto para evitar truncamiento

        // Configuración de las columnas de autor y fuente para mostrar los nombres en lugar de los IDs
        CRUD::column('autor_id')->label('Autor')
            ->type('select')
            ->entity('autor')
            ->attribute('nombre')
            ->model("App\Models\Citas\CitaAutor");

        CRUD::column('fuente_id')->label('Fuente')
            ->type('select')
            ->entity('fuente')
            ->attribute('titulo')
            ->limit(100000);

        // Configuración de la columna de texto
        CRUD::column('texto')->label('Texto')
            ->type('markdown') // Utiliza 'markdown' para mostrar HTML correctamente
            ->escaped(false) // Asegura que el HTML no sea escapado
            ->limit(100000); // Establece un límite alto para evitar truncamiento

        // Configuración de las columnas de autor y fuente para mostrar los nombres en lugar de los IDs
        CRUD::column('autor_id')->label('Autor')
            ->type('select')
            ->entity('autor')
            ->attribute('nombre')
            ->model("App\Models\Citas\CitaAutor");

        CRUD::column('fuente_id')->label('Fuente')
            ->type('select')
            ->entity('fuente')
            ->attribute('titulo')
            ->limit(100000)
            ->model("App\Models\Citas\CitaFuente");
    }
}
