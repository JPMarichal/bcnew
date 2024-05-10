<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CitaAutorRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class CitaAutorCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Citas\CitaAutor::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/cita-autor');
        CRUD::setEntityNameStrings('autor', 'autores');
    }

    protected function setupListOperation()
    {
        CRUD::column('nombre')->type('text')->label('Nombre');
        CRUD::column('tipo_autor_id')->type('select')
            ->label('Tipo de Autor')
            ->entity('tipoAutor') // Relación definida en el modelo CitaAutor
            ->attribute('descripcion') // Muestra la descripción del tipo de autor
            ->model("App\Models\Citas\TipoAutor"); // Utiliza el modelo TipoAutor
        CRUD::column('post_id')->type('select')
            ->label('Post Relacionado')
            ->entity('post')
            ->attribute('title')
            ->model("App\Models\Blog\Post");
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(CitaAutorRequest::class);

        CRUD::field('nombre')->type('text')->label('Nombre del Autor');
        CRUD::field('tipo_autor_id')->type('select')
            ->label('Tipo de Autor')
            ->entity('tipoAutor')
            ->attribute('descripcion')
            ->model("App\Models\Citas\TipoAutor");
        CRUD::field('post_id')->type('select')
            ->label('Post Relacionado')
            ->entity('post')
            ->attribute('title')
            ->model("App\Models\Blog\Post");
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
