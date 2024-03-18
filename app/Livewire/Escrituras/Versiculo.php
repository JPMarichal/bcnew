<?php

namespace App\Livewire\Escrituras;

use Livewire\Component;
use App\Models\Escrituras\Versiculo as ModeloVersiculo;

class Versiculo extends Component
{
    public $versiculo;
    public bool $esPar;

    public function mount(ModeloVersiculo $versiculo, bool $esPar)
    {
        // Asegúrate de cargar los comentarios aquí si aún no se han cargado.
        $this->versiculo = $versiculo;
        $this->esPar = $esPar;
    }

    public function render()
    {
        return view('livewire.escrituras.versiculo');
    }
}
