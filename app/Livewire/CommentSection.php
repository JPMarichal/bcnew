<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Blog\Post;
use App\Models\Blog\Comment;
use Illuminate\Support\Facades\Auth;

class CommentSection extends Component
{
    public $post;
    public $name;
    public $email;
    public $content;

    protected $rules = [
        'name' => 'required',
        'email' => 'nullable|email',
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
        $this->validate();

        $comment = new Comment();
        $comment->post_id = $this->post->id;
        $comment->author = $this->name;
        $comment->email = $this->email;
        $comment->content = $this->content;
        $comment->save();

        $this->reset(['name', 'email', 'content']);

        session()->flash('message', '¡Comentario agregado exitosamente!');
    }

    public function isUserComment($commentAuthorId)
    {
        return Auth::check() && Auth::id() === $commentAuthorId;
    }
}

