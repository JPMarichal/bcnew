<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PasajeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PasajeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PasajeCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Escrituras\Pasaje::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pasaje');
        CRUD::setEntityNameStrings('pasaje', 'pasajes');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('titulo')->type('text')->label('Título')->limit(75 );
        CRUD::addColumn([
            'name' => 'capitulo_id', // nombre del campo en la base de datos
            'label' => 'Capítulo', // etiqueta que se mostrará en el CRUD
            'type' => 'select',
            'entity' => 'capitulo', // el método que define la relación en el modelo
            'attribute' => 'referencia', // atributo del modelo Capitulo que se mostrará
            'model' => "App\Models\Escrituras\Capitulo"
        ]);
        CRUD::column('versiculo_inicial')->type('number')->label('Versículo Inicial');
        CRUD::column('versiculo_final')->type('number')->label('Versículo Final');
    }


    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PasajeRequest::class);

        CRUD::field('titulo')->type('text')->label('Título');
        CRUD::addField([
            'label'     => "Capítulo", // Label que se mostrará en el formulario
            'type'      => 'select',
            'name'      => 'capitulo_id', // la clave foránea en la tabla `pasajes`
            'entity'    => 'capitulo', // la función que define la relación en el modelo
            'attribute' => 'referencia', // atributo del modelo Capítulo que se mostrará en el dropdown
            'model'     => "App\Models\Escrituras\Capitulo", // el modelo desde donde se traerán los datos
            'options'   => (function ($query) {
                return $query->orderBy('referencia', 'ASC')->get(); // Ordena los capítulos alfabéticamente
            }),
        ]);
        CRUD::field('versiculo_inicial')->type('number')->label('Versículo Inicial');
        CRUD::field('versiculo_final')->type('number')->label('Versículo Final');
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

    /**
     * Define what happens when the Show operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-show
     * @return void
     */
    protected function setupShowOperation()
    {
        // Asegúrate de que estas columnas se añadan de forma que se muestren adecuadamente los detalles
        CRUD::column('titulo')->type('text')->label('Título')->limit(1000);
        CRUD::addColumn([
            'name' => 'capitulo_id', // campo en la base de datos
            'label' => 'Capítulo', // etiqueta para mostrar en la interfaz
            'type' => 'select',
            'entity' => 'capitulo', // el método que define la relación en el modelo
            'attribute' => 'referencia', // atributo del modelo Capitulo que se mostrará
            'model' => "App\Models\Escrituras\Capitulo"
        ]);
        CRUD::column('versiculo_inicial')->type('number')->label('Versículo Inicial');
        CRUD::column('versiculo_final')->type('number')->label('Versículo Final');
    }
}
