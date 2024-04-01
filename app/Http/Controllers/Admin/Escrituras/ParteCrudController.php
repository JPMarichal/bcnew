<?php

namespace App\Http\Controllers\Admin\Escrituras;

use App\Http\Requests\Escrituras\ParteRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ParteCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ParteCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Escrituras\Parte::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/escrituras/parte');
        CRUD::setEntityNameStrings('parte', 'partes');
        $this->crud->orderBy('libro_id', 'ASC')->orderBy('orden','ASC');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
      //  CRUD::setFromDb(); // set columns from db columns.

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */        
         CRUD::column([
            'name' => 'Libro',
            'label' => 'Libro',
            'type' =>'select',
            'entity' => 'libro',
            'attribute' => 'nombre',
            'model'=> 'App\Models\Escrituras\Libro',
            'orderable'=> false
        ]);
        CRUD::column('nombre')->type('string')->orderable(false);
        CRUD::column('orden')->type('number')->label('Cap Inicial')->orderable(false);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ParteRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
      //  CRUD::field('nombre')->validationRules('required|min:5');

    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
       // $this->setupCreateOperation();
        CRUD::field('nombre')->validationRules('required|min:5');
        CRUD::field([
            'name' => 'Libro',
            'type' =>'select',
            'entity' => 'libro', // the method that defines the relationship in your Model
            'attribute' => 'nombre', // foreign key attribute that is shown to user
            'model' => "App\Models\Escrituras\Libro", // foreign key model
            'options' => function ($query) {
                return $query->orderBy('id', 'asc')->get();
            },
        ]);
        CRUD::field('title')->validationRules('');
        CRUD::field('description')->validationRules('');
        CRUD::field('sumario')->validationRules('');
        CRUD::field('description')->validationRules('');
        CRUD::field('keywords')->validationRules('');
        CRUD::field('featured_image')->validationRules('');

    }
}
