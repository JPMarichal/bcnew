<?php

namespace App\Livewire\Escrituras;

use Livewire\Component;
use App\Models\Escrituras\Versiculo as ModeloVersiculo;
use App\Models\Escrituras\VersiculoComentario;

class Versiculo extends Component
{
    public ModeloVersiculo $versiculo;
    public bool $esPar;
    public bool $mostrarModal = false; // Propiedad para controlar la visibilidad del modal
    public $nuevoComentarioTitulo = '';
    public $nuevoComentarioContenido = '';

    public function mount(ModeloVersiculo $versiculo, bool $esPar)
    {
        $this->versiculo = $versiculo;
        $this->esPar = $esPar;
    }

    public function guardarComentario()
    {

        $this->validate([
            'nuevoComentarioTitulo' => 'required|string|max:255',
            'nuevoComentarioContenido' => 'required|string',
        ]);

        VersiculoComentario::create([
            'versiculo_id' => $this->versiculo->id,
            'titulo' => $this->nuevoComentarioTitulo,
            'comentario' => $this->nuevoComentarioContenido,
            'orden' => VersiculoComentario::where('versiculo_id', $this->versiculo->id)->max('orden') + 1,
        ]);

        $this->reset(['nuevoComentarioTitulo', 'nuevoComentarioContenido', 'mostrarModal']);
    }

    public function render()
    {
        return view('livewire.escrituras.versiculo');
    }
}
