<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\VideoRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class VideoCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Video::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/video');
        CRUD::setEntityNameStrings('video', 'videos');
    }

    protected function setupListOperation()
    {
        CRUD::column('title')->label('Título');
        CRUD::column('video_url')->label('URL del Video');
        CRUD::column('channel_title')->label('Título del Canal');
        CRUD::column('playlist_title')->label('Título de la Playlist');
        CRUD::column('publish_date')->label('Fecha de Publicación')->type('date');
        CRUD::column('user_name')->label('Nombre del Usuario');
        CRUD::column('language')->label('Idioma');
    }

    protected function setupCreateAndUpdateOperations()
    {
        CRUD::setValidation(VideoRequest::class);

        CRUD::field('title')->type('text')->label('Título del Video');
        CRUD::field('video_id')->type('text')->label('ID del Video');
        CRUD::field('video_url')->type('text')->label('URL del Video');
        CRUD::field('description')->type('textarea')->label('Descripción');
        CRUD::field('channel_id')->type('text')->label('ID del Canal');
        CRUD::field('channel_title')->type('text')->label('Título del Canal');
        CRUD::field('playlist_id')->type('text')->label('ID de la Playlist');
        CRUD::field('playlist_title')->type('text')->label('Título de la Playlist');
        CRUD::field('user_name')->type('text')->label('Nombre del Usuario');
        CRUD::field('user_id')->type('text')->label('ID del Usuario');
        CRUD::field('publish_date')->type('date')->label('Fecha de Publicación');
        CRUD::field('language')->type('text')->label('Idioma');
        CRUD::field('post_id')->type('number')->label('ID del Post Asociado');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateAndUpdateOperations();
    }

    protected function setupCreateOperation()
    {
        $this->setupCreateAndUpdateOperations();
    }
}
