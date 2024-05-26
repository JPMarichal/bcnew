<div>
    <div class="btn-group" role="group">
        @livewire('print-button', ['postId' => $post->id])
        @livewire('export-pdf-button', ['postId' => $post->id])
    </div>
</div>
