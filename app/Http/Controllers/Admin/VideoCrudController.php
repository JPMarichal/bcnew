<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\VideoRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class VideoCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class VideoCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Video::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/video');
        CRUD::setEntityNameStrings('video', 'videos');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('title')->label('Título');
        CRUD::column('platform')->label('Plataforma');
        CRUD::column('video_url')->label('URL del Video');
        CRUD::column('publish_date')->label('Fecha de Publicación')->type('date');
        CRUD::column('likes_count')->label('Me gusta')->type('number');
        CRUD::column('comments_count')->label('Comentarios')->type('number');
        CRUD::column('shares_count')->label('Compartidos')->type('number');
        CRUD::column('user_name')->label('Nombre del Usuario');
        CRUD::column('hashtags')->label('Hashtags');
        CRUD::column('video_duration')->label('Duración (segundos)')->type('number');
    }

    /**
     * Define what happens when the Create and Update operations are loaded.
     * 
     * @return void
     */
    protected function setupCreateAndUpdateOperations()
    {
        CRUD::setValidation(VideoRequest::class);

        // Agregar campos al CRUD
        CRUD::field('title')->type('text')->label('Título del Video');
        CRUD::field('video_id')->type('text')->label('ID del Video');
        CRUD::field('description')->type('textarea')->label('Descripción');
        CRUD::field('platform')->type('select_from_array')
            ->options(['youtube' => 'YouTube', 'tiktok' => 'TikTok'])
            ->label('Plataforma')
            ->default('youtube');
        CRUD::field('video_url')->type('text')->label('URL del Video');
        CRUD::field('publish_date')->type('date')
            ->label('Fecha de Publicación')
            ->attributes(['type' => 'date']);
        CRUD::field('likes_count')->type('number')->label('Me gusta')->default(0);
        CRUD::field('comments_count')->type('number')->label('Comentarios')->default(0);
        CRUD::field('shares_count')->type('number')->label('Compartidos')->default(0);
        CRUD::field('user_name')->type('text')->label('Nombre del Usuario');
        CRUD::field('hashtags')->type('text')->label('Hashtags');
        CRUD::field('video_duration')->type('number')->label('Duración en segundos');
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateAndUpdateOperations();
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @return void
     */
    protected function setupCreateOperation()
    {
        $this->setupCreateAndUpdateOperations();
    }
}
