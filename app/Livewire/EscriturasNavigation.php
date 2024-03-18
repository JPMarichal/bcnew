<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Escrituras\Volumen;
use App\Models\Escrituras\Libro;
use App\Models\Escrituras\Capitulo;

class EscriturasNavigation extends Component
{
    public $volumenes, $libros, $capitulos;
    public $volumenSeleccionado, $libroSeleccionado, $capituloSeleccionado;

    protected $listeners = ['cargarContexto'];

    public function mount($tipo = null, $nombre = null)
    {
        $this->volumenes = Volumen::orderBy('id')->get();
        $this->libros = collect();
        $this->capitulos = collect();

        if (!is_null($tipo) && !is_null($nombre)) {
            $this->cargarContexto($tipo, $nombre);
        }
    }

    public function updatedVolumenSeleccionado($volumenId)
    {
        $this->libros = Libro::where('volumen_id', $volumenId)->orderBy('id')->get();
        $this->reset(['capitulos', 'libroSeleccionado', 'capituloSeleccionado']);
    }

    public function updatedLibroSeleccionado($libroId)
    {
        $this->capitulos = Capitulo::where('libro_id', $libroId)->orderBy('id')->get();
        $this->reset(['capituloSeleccionado']);
    }

    public function cargarContexto($tipo, $nombre)
    {
        switch ($tipo) {
            case 'volumen':
                $volumen = Volumen::where('nombre', $nombre)->first();
                if ($volumen) {
                    $this->volumenSeleccionado = $volumen->id;
                    $this->libros = $volumen->libros()->orderBy('id')->get();
                }
                break;
            case 'libro':
                $libro = Libro::where('nombre', $nombre)->with('volumen')->first();
                if ($libro) {
                    $this->libroSeleccionado = $libro->id;
                    $this->volumenSeleccionado = $libro->volumen->id;
                    $this->libros = $libro->volumen->libros()->orderBy('id')->get();
                    $this->capitulos = $libro->capitulos()->orderBy('id')->get();
                }
                break;
            case 'capitulo':
                $capitulo = Capitulo::where('referencia', $nombre)->with('libro.volumen')->first();
                if ($capitulo) {
                    $this->capituloSeleccionado = $capitulo->id;
                    $this->libroSeleccionado = $capitulo->libro->id;
                    $this->volumenSeleccionado = $capitulo->libro->volumen->id;
                    $this->libros = $capitulo->libro->volumen->libros()->orderBy('id')->get();
                    $this->capitulos = $capitulo->libro->capitulos()->orderBy('id')->get();
                }
                break;
        }
    }

    public function navegar($tipo)
    {
        $nombre = '';

        switch ($tipo) {
            case 'volumen':
                $nombre = optional(Volumen::find($this->volumenSeleccionado))->nombre;
                $ruta = $nombre ? route('volumenes.show', ['nombre' => $nombre]) : null;
                break;
            case 'libro':
                $nombre = optional(Libro::find($this->libroSeleccionado))->nombre;
                $ruta = $nombre ? route('libros.show', ['nombre' => $nombre]) : null;
                break;
            case 'capitulo':
                $nombre = optional(Capitulo::find($this->capituloSeleccionado))->referencia;
                $ruta = $nombre ? route('capitulos.show', ['nombre' => $nombre]) : null;
                break;
        }

        if ($ruta) {
            return redirect($ruta);
        }
    }

    public function render()
    {
        return view('livewire.escrituras-navigation');
    }
}
