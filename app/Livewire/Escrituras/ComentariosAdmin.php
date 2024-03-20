<?php

namespace App\Livewire\Escrituras;

use Livewire\Component;
use App\Models\Escrituras\Versiculo;
use App\Models\Escrituras\VersiculoComentario;

class ComentariosAdmin extends Component
{
    public $versiculoId;
    public $titulo = '';
    public $comentario = '';
    public $comentarioId = null;

    protected $rules = [
        'titulo' => 'required|string|max:255',
        'comentario' => 'required|string',
    ];

    public function mount($versiculoId)
    {
        $this->versiculoId = $versiculoId;
    }

    public function render()
    {
        $versiculo = Versiculo::find($this->versiculoId);
        $comentarios = $versiculo->comentarios()->orderBy('orden')->get();
        return view('livewire.escrituras.comentarios-admin', compact('versiculo', 'comentarios'));
    }

    public function saveComment()
    {
        $this->validate();

        $orden = VersiculoComentario::where('versiculo_id', $this->versiculoId)->max('orden') + 1;

        VersiculoComentario::create([
            'versiculo_id' => $this->versiculoId,
            'titulo' => $this->titulo,
            'comentario' => $this->comentario,
            'orden' => $orden,
        ]);

        $this->resetInput();
    }

    public function edit($id)
    {
        $comentario = VersiculoComentario::findOrFail($id);
        $this->comentarioId = $comentario->id;
        $this->titulo = $comentario->titulo;
        $this->comentario = $comentario->comentario;
    }

    public function updateComment()
    {
        $this->validate();

        if ($this->comentarioId) {
            $comentario = VersiculoComentario::find($this->comentarioId);
            $comentario->update([
                'titulo' => $this->titulo,
                'comentario' => $this->comentario,
            ]);
        }

        $this->resetInput();
    }

    public function confirmDelete($id)
    {
        if ($confirm = true) { // Implementa una lógica de confirmación adecuada
            $this->deleteComment($id);
        }
    }

    public function deleteComment($id)
    {
        VersiculoComentario::find($id)->delete();
    }

    public function moveUp($id)
    {
        $currentComment = VersiculoComentario::find($id);
        $previousComment = VersiculoComentario::where('versiculo_id', $this->versiculoId)
            ->where('orden', '<', $currentComment->orden)
            ->orderBy('orden', 'desc')
            ->first();

        if ($previousComment) {
            $currentOrder = $currentComment->orden;
            $currentComment->orden = $previousComment->orden;
            $previousComment->orden = $currentOrder;
            $currentComment->save();
            $previousComment->save();
        }
    }

    public function moveDown($id)
    {
        $currentComment = VersiculoComentario::find($id);
        $nextComment = VersiculoComentario::where('versiculo_id', $this->versiculoId)
            ->where('orden', '>', $currentComment->orden)
            ->orderBy('orden', 'asc')
            ->first();

        if ($nextComment) {
            $currentOrder = $currentComment->orden;
            $currentComment->orden = $nextComment->orden;
            $nextComment->orden = $currentOrder;
            $currentComment->save();
            $nextComment->save();
        }
    }

    private function resetInput()
    {
        $this->reset(['titulo', 'comentario', 'comentarioId']);
    }
}
