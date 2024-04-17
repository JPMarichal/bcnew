<?php

namespace App\Http\Livewire;

use Livewire\Component;

class HeroH2 extends Component
{
    public $backgroundImageUrl;
    public $headerText;

    public function render()
    {
        return view('livewire.hero-header');
    }
}
