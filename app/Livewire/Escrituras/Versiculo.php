<?php
namespace App\Livewire\Escrituras;

use Livewire\Component;
use App\Models\Escrituras\Versiculo as ModeloVersiculo;

class Versiculo extends Component
{
    public ModeloVersiculo $versiculo;
    public bool $esPar;

    public function mount(ModeloVersiculo $versiculo, bool $esPar)
    {
        $this->versiculo = $versiculo;
        $this->esPar = $esPar;
    }

    public function render()
    {
        return view('livewire.escrituras.versiculo');
    }
}
