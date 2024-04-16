<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Blog\Post;

class CleanWordPressBlocks extends Command
{
    protected $signature = 'posts:clean-blocks';
    protected $description = 'Elimina solo los comentarios de bloques de WordPress de los posts';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Iniciando la limpieza de comentarios de bloques de WordPress en posts...');

        Post::where('post_type', 'post') // Asegura procesar solo los posts
            ->chunk(100, function ($posts) {
                foreach ($posts as $post) {
                    // Eliminación de comentarios de apertura y cierre
                    $post->content = preg_replace('/<!-- wp:.*? -->/', '', $post->content); // Elimina comentarios de apertura
                    $post->content = preg_replace('/<!-- \/wp:.*? -->/', '', $post->content); // Elimina comentarios de cierre
                    $post->save();
                    
                    $this->info('Post actualizado: ' . $post->id);
                }
            });

        $this->info('La limpieza de comentarios de bloques de WordPress ha sido completada.');
    }
}
