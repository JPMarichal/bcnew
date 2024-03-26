<?php

namespace App\Livewire\Escrituras;

use Livewire\Component;
use App\Models\Escrituras\Libro;
use App\Models\Escrituras\Parte;
use App\Models\Escrituras\Capitulo;

class ParteCrud extends Component
{
    public $libros, $libro_id, $capitulos, $partes, $titulo, $parte_id = null;
    public $capitulo_inicial_id, $capitulo_final_id;
    public $modoEdicion = false;

    protected $listeners = ['eliminarParte' => 'eliminar'];

    protected $rules = [
        'libro_id' => 'required',
        'titulo' => 'required|string|max:255',
        'capitulo_inicial_id' => 'required|numeric',
        'capitulo_final_id' => 'required|numeric',
    ];

    public function mount()
    {
        $this->libros = Libro::orderBy('id', 'asc')->get();
    }

    public function cambiarLibro($libroId)
    {
        $this->libro_id = $libroId;
        $this->updatedLibroId($libroId);
    }

    public function updatedLibroId($value)
    {
        $this->reset(['titulo', 'capitulo_inicial_id', 'capitulo_final_id', 'parte_id', 'modoEdicion']);
        if (!empty($value)) {
            $this->capitulos = Capitulo::where('libro_id', $value)->orderBy('id', 'asc')->get();
        } else {
            $this->capitulos = [];
        }
    }

    public function guardar()
    {
        $this->validate();

        $parte = new Parte();
        if ($this->parte_id) {
            $parte = Parte::find($this->parte_id);
        }

        $parte->fill([
            'libro_id' => $this->libro_id,
            'nombre' => $this->titulo,
            'orden' => $this->capitulo_inicial_id, // Ajustar según la lógica de orden
            // Agregar más campos si es necesario
        ]);
        $parte->save();

        // Actualizar capítulos si es necesario

        $this->reset(['titulo', 'capitulo_inicial_id', 'capitulo_final_id', 'parte_id', 'modoEdicion']);
        $this->dispatch('alert', 'La parte ha sido guardada con éxito.');
    }

    public function confirmarEliminacion($parteId)
    {
        $this->dispatch('confirmarEliminacion', ['parteId' => $parteId]);
    }

    public function editar($parteId)
    {
        $this->modoEdicion = true;
        $this->parte_id = $parteId;
        $parte = Parte::find($parteId);
        $this->titulo = $parte->nombre;
        // Ajustar el resto de campos
    }

    public function eliminar($parteId)
    {
        $parte = Parte::find($parteId);
        if ($parte) {
            $parte->delete();
            $this->dispatch('alertDelete', 'Parte eliminada con éxito.');
        }
    }

    public function render()
    {
        $this->partes = $this->libro_id ? Parte::where('libro_id', $this->libro_id)->orderBy('orden', 'asc')->get() : [];
        return view('livewire.escrituras.parte-crud', [
            'capitulos' => $this->libro_id ? Capitulo::where('libro_id', $this->libro_id)->get() : [],
        ]);
    }

    public function getLibroProperty()
    {
        return Libro::find($this->libro_id);
    }
}
