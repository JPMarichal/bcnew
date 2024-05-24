<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog\Post;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BlogController extends Controller
{
    public function index()
    {
        $types = config('blogTypes.post_types');
        asort($types);
        $title = 'El blog de los Biblicomentarios';

        return view('blog.main', compact('types', 'title'));
    }

    public function filter($type)
    {
        $types = config('blogTypes.post_types');

        if (!array_key_exists($type, $types)) {
            abort(404); // Si el tipo de post no está definido, muestra un error 404
        }

        $posts = Post::where('status', 'published')
                     ->where('post_type', $type)
                     ->paginate(15);

        $title = $types[$type];

        return view('blog.index', compact('posts', 'title'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('blog.show', compact('post'));
    }

    public function print($postId)
    {
        $post = Post::findOrFail($postId);
        return view('print', compact('post'));
    }

    public function pdf($postId)
    {
        $post = Post::findOrFail($postId);
        $pdf = PDF::loadView('pdf', compact('post'));
        return $pdf->download('post.pdf');
    }
}
