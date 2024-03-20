<div>
    <div>
        <button class="btn btn-primary float-end mb-3" wire:click="clearForm()">Nuevo Comentario</button>

        <form wire:submit.prevent="{{ $comentarioId ? 'updateComment' : 'saveComment' }}">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" wire:model.defer="titulo" required>
            </div>
            <div class="mb-3">
                <label for="comentario" class="form-label">Comentario</label>
                <textarea class="form-control" id="comentario" rows="5" wire:model.defer="comentario"></textarea>
            </div>
            <div class="mb-3">
                @if($comentarioId)
                <button type="submit" class="btn btn-warning">Actualizar</button>
                @else
                <button type="submit" class="btn btn-success">Guardar</button>
                @endif
                <button type="button" class="btn btn-secondary" wire:click="clearForm()">Limpiar</button>
            </div>
        </form>

        <div class="mt-4">
            <div class="list-group">
                @foreach($comentarios as $comentario)
                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div>{{ $comentario->titulo }}</div>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-secondary" wire:click="moveUp({{ $comentario->id }})">
                            <i class="fas fa-arrow-up"></i>
                        </button>
                        <button class="btn btn-sm btn-secondary" wire:click="moveDown({{ $comentario->id }})">
                            <i class="fas fa-arrow-down"></i>
                        </button>
                        <button class="btn btn-sm btn-info" wire:click="edit({{ $comentario->id }})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" wire:click="confirmDelete({{ $comentario->id }})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.hook('message.processed', (message, component) => {
                tinymce.remove('#comentario');
                tinymce.init({
                    selector: '#comentario',
                    setup: function(editor) {
                        editor.on('change', function() {
                            @this.set('comentario', editor.getContent());
                        });
                    }
                });
            });
        });
    </script>
</div>