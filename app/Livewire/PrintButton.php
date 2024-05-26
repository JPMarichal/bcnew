<?php

namespace App\Livewire;

use Livewire\Component;

class PrintButton extends Component
{
    public $postId;

    public function mount($postId)
    {
        $this->postId = $postId;
    }

    public function print()
    {
        $this->dispatch('print', ['url' => route('post.printPage', ['postId' => $this->postId])]);
    }

    public function render()
    {
        return view('livewire.print-button');
    }
}
