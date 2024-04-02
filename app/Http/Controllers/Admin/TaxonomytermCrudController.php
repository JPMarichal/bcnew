<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TaxonomytermRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class TaxonomytermCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\TaxonomyTerm::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/taxonomyterm');
        CRUD::setEntityNameStrings('término', 'términos');
    }

    protected function setupListOperation()
    {
        CRUD::column('taxonomy_id')->label('Taxonomía')->type('select')->entity('taxonomy')->attribute('name')->model("App\Models\Taxonomy");
        
        CRUD::column('name')->type('text')->label('Nombre');

        // Columna para 'parent_id' que muestra el nombre del término padre
        CRUD::column('parent_id')->label('Término Padre')->type('select')->entity('parent')->attribute('name')->model("App\Models\TaxonomyTerm");

        // Columna para 'created_by' que muestra el nombre del usuario
        CRUD::column('created_by')->label('Creado Por')->type('select')->entity('createdBy')->attribute('name')->model("App\Models\User");
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(TaxonomytermRequest::class);

        CRUD::field('name')->type('text')->label('Nombre');
        CRUD::field('taxonomy_id')->label('Taxonomía')->type('select')->entity('taxonomy')->model("App\Models\Taxonomy")->attribute('name');
        CRUD::field('parent_id')->label('Término Padre')->type('select')->entity('parent')->model("App\Models\TaxonomyTerm")->attribute('name');
        CRUD::field('created_by')->label('Creado por')->type('select')->entity('createdBy')->model("App\Models\User")->attribute('name');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
