<?php
namespace App\Livewire;

use Livewire\Component;
use App\Services\CitaService;

class RandomQuote extends Component
{
    public $quote = '';

    protected $citaService;

    public function mount(CitaService $citaService)
    {
        $this->citaService = $citaService;
        $this->quote = $this->citaService->obtenerCitaAleatoriaParaWeb();
    }

    public function render()
    {
        return view('livewire.random-quote');
    }
}
