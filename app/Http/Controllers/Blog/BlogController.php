<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function indexdd() 
    {
        $posts = Post::where('status', 'published')
            ->where('post_type','post')
            ->paginate(15);
        return view('blog.index', compact('posts'));
    }

    public function index()
    {
        // Ordena los posts por fecha en orden descendente, la última fecha primero
        $posts = Post::select('posts.*')
                     ->where('posts.post_type', 'post')
                     ->where('posts.status', 'published')
                     ->orderBy('created_at', 'desc')
                     ->paginate(15);

        return view('blog.index', compact('posts'));
    }

    public function celebracion()
    {
        // Obtener los posts utilizando joins para imitar la consulta SQL proporcionada
        $posts = Post::select('posts.*')
                     ->where('posts.post_type', 'celebracion')
                     ->where('posts.status', 'published')
                     ->paginate(15);

        return view('blog.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('blog.show', compact('post'));
    }


// Filtrados de acuerdo a una característica específica

    public function sinThumbnail()
    {
        // Obtener los posts utilizando joins para imitar la consulta SQL proporcionada
        $posts = Post::select('posts.*')
                     ->join('posts as attachments', function ($join) {
                         $join->on('posts.id', '=', 'attachments.post_parent')
                              ->where('attachments.post_type', 'attachment')
                              ->where('attachments.slug', 'not like', '%b-cdn%');
                     })
                     ->join('post_meta', function ($join) {
                         $join->on('post_meta.meta_value', '=', 'attachments.id')
                              ->where('post_meta.meta_key', '=', '_thumbnail_id');
                     }) 
                     ->where('posts.post_type', 'post')
                     ->where('posts.status', 'published')
                     ->paginate(15);

        return view('blog.index', compact('posts'));
    }
}
