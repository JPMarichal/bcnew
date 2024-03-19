<?php

namespace App\Livewire\Escrituras;

use Livewire\Component;
use App\Models\Escrituras\Versiculo as ModeloVersiculo;
use App\Models\Escrituras\VersiculoComentario;

class Versiculo extends Component
{
    public ModeloVersiculo $versiculo;
    public bool $esPar;
    public $mostrarModalAgregarComentario = false;
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
            'versiculo_id' => $this->versiculo->id, // Acceder directamente al id del versículo
            'titulo' => $this->nuevoComentarioTitulo,
            'comentario' => $this->nuevoComentarioContenido,
            'orden' => VersiculoComentario::where('versiculo_id', $this->versiculo->id)->max('orden') + 1 ?? 0,
        ]);

        $this->mostrarModalAgregarComentario = false;
        $this->versiculo->load('comentarios'); // Recargar los comentarios para incluir el nuevo
        $this->emit('comentarioAgregado'); // Opcional: Emitir un evento si necesitas actualizar alguna parte de tu componente o realizar alguna acción después de agregar un comentario.
    }

    public function render()
    {
        return view('livewire.escrituras.versiculo');
    }
}
