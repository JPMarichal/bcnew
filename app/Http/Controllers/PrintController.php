<?php

namespace App\Http\Controllers;

use App\Models\Blog\Post;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function show($postId)
    {
        $post = Post::findOrFail($postId);
        return view('print', compact('post'));
    }
}
