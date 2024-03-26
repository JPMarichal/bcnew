<?php

namespace App\Livewire\Escrituras;

use Livewire\Component;
use App\Models\Escrituras\Libro;
use App\Models\Escrituras\Parte;
use App\Models\Escrituras\Capitulo;

class ParteCrud extends Component
{
    public $libros, $libro_id, $capitulos, $partes, $titulo = null, $parte_id = null;
    public $capitulo_inicial_id = null, $capitulo_final_id = null;
    public $modoEdicion = false;

    protected $listeners = ['eliminarParte' => 'eliminar'];

    protected $rules = [
        'libro_id' => 'required',
        'titulo' => 'required|string|max:255',
        'capitulo_inicial_id' => 'required|numeric',
        'capitulo_final_id' => 'required|numeric',
        'capitulo_final_id' => 'required|numeric|gte:capitulo_inicial_id',
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
        try {
            $this->validate(null, [
                'libro_id.required' => 'Es necesario seleccionar un libro.',
                'titulo.required' => 'El campo título es obligatorio.',
                'capitulo_inicial_id.required' => 'Debes elegir un capítulo inicial.',
                'capitulo_final_id.required' => 'Debes elegir un capítulo final.',
                'capitulo_final_id.gte' => 'El capítulo final debe ser posterior o igual al capítulo inicial.',
            ]);

            $parte = new Parte();

            $parte->fill([
                'libro_id' => $this->libro_id,
                'nombre' => $this->titulo,
                'orden' => $this->capitulo_inicial_id
            ]);
            $parte->save();

            $parte->nombre = $this->titulo;
            $parte->orden = $this->capitulo_inicial_id; // Asegúrate de que este campo se maneja según tus requisitos
            $parte->save();

            // Actualizar capítulos en el rango
            Capitulo::where('libro_id', $this->libro_id)
                ->whereBetween('id', [$this->capitulo_inicial_id, $this->capitulo_final_id])
                ->update(['parte_id' => $parte->id]);

            $this->reset(['titulo', 'capitulo_inicial_id', 'capitulo_final_id', 'parte_id', 'modoEdicion']);
            $this->dispatch('alertaOperacion', 'La parte ha sido guardada con éxito.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('swal:modal', [
                'type' => 'error',
                'title' => 'Error de validación',
                'text' => implode(", ", array_flatten($e->errors())),
            ]);
        } catch (\Exception $e) {
            $this->dispatch('swal:modal', [
                'type' => 'error',
                'title' => 'Error',
                'text' => $e->getMessage(),
            ]);
        }
    }

    public function confirmarEliminacion($parteId)
    {
        $this->dispatch('confirmarEliminacion', ['parteId' => $parteId]);
    }

    public function actualizar()
    {
        try {
            $this->validate(null, [
                'libro_id.required' => 'Es necesario seleccionar un libro.',
                'titulo.required' => 'El campo título es obligatorio.',
                'capitulo_inicial_id.required' => 'Debes elegir un capítulo inicial.',
                'capitulo_final_id.required' => 'Debes elegir un capítulo final.',
                'capitulo_final_id.gte' => 'El capítulo final debe ser posterior o igual al capítulo inicial.',
            ]);

            $parte = Parte::find($this->parte_id);

            if (!$parte) {
                throw new \Exception("La parte no existe.");
            }

            $parte->update([
                'libro_id' => $this->libro_id,
                'nombre' => $this->titulo,
                'orden' => $this->capitulo_inicial_id
            ]);

            // Actualizar capítulos en el rango
            Capitulo::where('libro_id', $this->libro_id)
                ->whereBetween('id', [$this->capitulo_inicial_id, $this->capitulo_final_id])
                ->update(['parte_id' => $parte->id]);

            $this->reset(['titulo', 'capitulo_inicial_id', 'capitulo_final_id', 'parte_id', 'modoEdicion']);
            $this->modoEdicion = false;
            $this->dispatch('alertaOperacion', 'La parte ha sido actualizada con éxito.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('swal:modal', [
                'type' => 'error',
                'title' => 'Error de validación',
                'text' => implode(", ", array_flatten($e->errors())),
            ]);
        } catch (\Exception $e) {
            $this->dispatch('swal:modal', [
                'type' => 'error',
                'title' => 'Error',
                'text' => $e->getMessage(),
            ]);
        }
    }

    public function eliminar($parteId)
    {
        $parte = Parte::find($parteId);
        if ($parte) {
            $parte->delete();
            $this->dispatch('alertaOperacion', 'Parte eliminada con éxito.');
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
