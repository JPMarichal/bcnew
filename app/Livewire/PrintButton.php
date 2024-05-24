<?php

namespace App\Livewire;

use Livewire\Component;

class PrintButton extends Component
{
    public function print()
    {
        $this->dispatch('print');
    }

    public function render()
    {
        return view('livewire.print-button');
    }
}

