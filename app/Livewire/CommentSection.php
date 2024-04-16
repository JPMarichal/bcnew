<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Blog\Post;
use App\Models\Blog\Comment;
use Illuminate\Support\Facades\Auth;

class CommentSection extends Component
{
    public $post;
    public $content;

    protected $rules = [
        'content' => 'required',
    ];

    public function mount(Post $post)
    {
        $this->post = $post;
    }

    public function render()
    {
        $comments = $this->post->comments()->with('replies')->latest()->get();

        return view('livewire.comment-section', compact('comments'));
    }

    public function addComment()
    {
        if (!Auth::check()) {
            session()->flash('message', 'Debes iniciar sesión para agregar un comentario.');
            return;
        }

        $this->validate();

        $user = Auth::user();

        $comment = new Comment();
        $comment->post_id = $this->post->id;
        $comment->user_id = $user->id;
        $comment->content = $this->content;
        $comment->save();

        $this->reset(['content']);

        session()->flash('message', '¡Comentario agregado exitosamente!');
    }

    public function isUserComment($commentAuthorId)
    {
        return Auth::check() && Auth::id() === $commentAuthorId;
    }
}
