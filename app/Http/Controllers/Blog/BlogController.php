<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 'published')
            ->where('post_type', 'post')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('blog.index', compact('posts'));
    }

    public function filter($type)
    {
        $titles = config('blogTypes.post_types');

        if (!array_key_exists($type, $titles)) {
            abort(404); // Si el tipo de post no está definido, muestra un error 404
        }

        $posts = Post::where('status', 'published')
            ->where('post_type', $type)
            ->paginate(15);

        $title = $titles[$type]; // Obtiene el título desde la configuración

        return view('blog.index', compact('posts', 'title'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('blog.show', compact('post'));
    }
}
