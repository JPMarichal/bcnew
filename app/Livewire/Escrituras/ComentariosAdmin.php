<?php

namespace App\Livewire\Escrituras;

use Livewire\Component;
use App\Models\Escrituras\Versiculo;
use App\Models\Escrituras\VersiculoComentario;
use Monolog\Logger;
use Livewire\Attributes\On;

class ComentariosAdmin extends Component
{
    public $versiculoId;
    public $titulo = '';
    public $comentario = '';
    public $comentarioId = null;
    public $comentarios = [];
    public $reRenderKey = 0;

    protected $listeners = [
        'proceedWithSave' => 'saveComment',
        'actualizarComentario' => 'actualizarComentario',
        'initUpdateComment' => 'initUpdateComment',
        'initSaveComment' => 'initSaveComment',
    ];

    protected $rules = [
        'titulo' => 'required|string|max:255',
        'comentario' => 'string',
    ];

    public function mount($versiculoId)
    {
        $this->versiculoId = $versiculoId;
        $this->loadComments();
    }

    public function render()
    {
        $versiculo = Versiculo::find($this->versiculoId);
        $comentarios = $versiculo->comentarios()->orderBy('orden')->get();
        return view('livewire.escrituras.comentarios-admin', compact('versiculo', 'comentarios'));
    }

    public function actualizarComentario($contenido)
    {
        $this->comentario = $contenido;

        //   $this->saveComment();
    }

    public function initSaveComment($contenido)
    {
        $this->comentario = $contenido;
        $this->saveComment();
    }

    public function initUpdateComment()
    {
        $this->updateComment();
    }

    public function saveComment()
    {
        $this->validate();

        $orden = VersiculoComentario::where('versiculo_id', $this->versiculoId)->max('orden') + 1;


        VersiculoComentario::create([
            'versiculo_id' => $this->versiculoId,
            'titulo' => $this->titulo,
            'comentario' =>  $this->comentario,
            'orden' => $orden,
        ]);

        $this->clearForm();
        $this->dispatch('reset-form');
    }

    public function edit($id)
    {
        $comentario = VersiculoComentario::findOrFail($id);
        $this->comentarioId = $comentario->id;
        $this->titulo = $comentario->titulo;
        $this->comentario = $comentario->comentario;

        $this->dispatch('editing-comment',$comentario);
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

        $this->clearForm();
    }

    public function clearForm()
    {
        $this->reset(['titulo', 'comentario', 'comentarioId']);
        $this->loadComments();
        $logger = new Logger('name');
        $this->dispatch('clear-tinymce', ['versiculoId' => $this->versiculoId]);
        $logger->info('Formulario limpiado');
    }

    public function confirmDelete($id)
    {
        if ($confirm = true) { // Implementa una lógica de confirmación adecuada
            $this->deleteComment($id);
        }
    }

    public function deleteComment($id)
    {
        $comentario = VersiculoComentario::find($id);
        if ($comentario) {
            $comentario->delete();
            // Incrementar reRenderKey para forzar la re-renderización
            $this->reRenderKey++;
            $this->loadComments(); 
        }
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

        $this->reRenderKey++; // Incrementar la clave para forzar re-renderización
        $this->loadComments();
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

        $this->reRenderKey++; // Incrementar la clave para forzar re-renderización
        $this->loadComments();
    }

    protected function loadComments()
    {
        $versiculo = Versiculo::find($this->versiculoId);
        $this->comentarios = collect($versiculo->comentarios()->orderBy('orden')->get());
        $this->dispatch('moved');
    }
}
