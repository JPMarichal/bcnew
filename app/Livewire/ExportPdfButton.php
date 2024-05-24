<?php
namespace App\Livewire;

use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Blog\Post;

class ExportPdfButton extends Component
{
    public $postId;

    public function export()
    {
        $post = Post::findOrFail($this->postId);
        $pdf = PDF::loadView('pdf', ['post' => $post]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'post.pdf');
    }

    public function render()
    {
        return view('livewire.export-pdf-button');
    }
}
