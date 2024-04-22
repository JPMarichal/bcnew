<?php
namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class UploadImage extends Component
{
    public $postId;

    public function mount($postId)
    {
        $this->postId = $postId;
    }

    public function uploadImage()
    {
        $response = Http::post("http://bcnew.top/api/upload-image/{$this->postId}");

        // Verificar la respuesta y manejar errores si es necesario
        if ($response->successful()) {
            $this->emit('imageUploaded'); // Emitir un evento para recargar la página
        } else {
            $this->emit('error', 'No se pudo cargar la imagen.');
        }
    }

    public function render()
    {
        return view('livewire.upload-image');
    }
}

