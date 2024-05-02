<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tema;

class TemasAdmin extends Component
{
    public $temas;

    public function mount()
    {
        $this->temas = Tema::orderBy('orden')->get();
    }

    public function render()
    {
        return view('livewire.temas-admin');
    }

    public function updateOrder($oldIndex, $newIndex)
    {
        // Añadir lógica para actualizar el orden de los temas
    }

    public function edit($id)
    {
        // Añadir lógica para editar un tema
    }
}
