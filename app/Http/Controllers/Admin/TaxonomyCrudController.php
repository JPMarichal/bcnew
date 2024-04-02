<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TaxonomyRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TaxonomyCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TaxonomyCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Taxonomy::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/taxonomy');
        CRUD::setEntityNameStrings('taxonomía', 'taxonomías');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // set columns from db columns.

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(TaxonomyRequest::class);

        CRUD::field('name')
            ->type('text')
            ->attributes(['placeholder' => 'Ingrese el nombre'])
            ->wrapper(['class' => 'form-group col-md-6']);

        CRUD::field('type')
            ->label("Type")
            ->type('select_from_array')
            ->options(['Clasificador' => 'Clasificador'])
            ->allows_null(false)
            ->default('Clasificador')
            ->wrapper(['class' => 'form-group col-md-6']);

        // Agregar el campo is_hierarchical como un switch
        CRUD::field([
            'name' => 'is_hierarchical',
            'label' => 'Es Jerárquica',
            'type' => 'checkbox',
            'hint' => 'Marcar si la taxonomía permite una jerarquía de términos.'
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation(); // Reutiliza la configuración de la operación de creación
    }
}
