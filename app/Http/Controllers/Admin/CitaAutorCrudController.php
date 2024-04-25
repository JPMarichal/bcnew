<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CitaAutorRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CitaAutorCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
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
        CRUD::column('url_imagen')->type('image')->label('Imagen');
        CRUD::column('post_id')->type('select')->label('Post Relacionado')
             ->entity('post')->attribute('title')->model("App\Models\Blog\Post");
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(CitaAutorRequest::class);

        CRUD::field('nombre')->type('text')->label('Nombre del Autor');
        CRUD::field('url_imagen')->type('text')->label('URL de la Imagen del Autor');
        CRUD::field('post_id')->type('select')->label('Post Relacionado')
             ->entity('post')->attribute('title')->model("App\Models\Blog\Post");
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
