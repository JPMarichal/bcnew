<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Blog\Post; 

class PostUtilities extends Component
{
    public $postId;
    public $post;

    public function mount($postId)
    {
        $this->postId = $postId;
        $this->post = Post::findOrFail($postId);
    }

    public function render()
    {
        return view('livewire.post-utilities', [
            'post' => $this->post
        ]);
    }
}
