<div>
    <div>
        <button class="btn btn-primary  mb-3" wire:click="clearForm()">Nuevo Comentario</button>

        <div class="px-5">
            <form wire:submit.prevent="{{ $comentarioId ? 'updateComment' : 'saveComment' }}">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="titulo" wire:model.defer="titulo" required>
                </div>
                <div class="mb-3" wire:ignore>
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
        </div>

        <div class="mt-4">
            <div class="list-group" wire:key="comentarios-list-{{ $reRenderKey }}">
                @foreach($comentarios as $comentario)
                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" wire:key="comentario-{{ $comentario->id }}-{{ $reRenderKey }}">
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
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOMContentLoaded  ');
            Livewire.on('moved', (component, property, value) => {
                console.log('Dentro del evento moved');
                initializeTinyMCE();
            });
        });

        document.addEventListener('livewire:load', function() {
            Livewire.hook('element.updated', function(el, component) {
                // Verifica si el elemento actualizado es relevante para reiniciar TinyMCE
                if (el.id === 'comentario') {
                    if (tinymce.get('comentario')) {
                        tinymce.get('comentario').remove();
                    }
                    initializeTinyMCE();
                }
            });

            initializeTinyMCE(); // Inicializa TinyMCE cuando el componente de Livewire se carga
        });

        function initializeTinyMCE() {
            console.log("Inicializando TinyMCE");
            tinymce.init({
                selector: '#comentario',
                menubar: true,
                language: 'es',
                plugins: [
                    'advlist',
                    'autolink',
                    'autosave',
                    'lists',
                    'link',
                    'image',
                    'charmap',
                    'preview',
                    'anchor',
                    'searchreplace',
                    'visualblocks',
                    'code',
                    'fullscreen',
                    'insertdatetime',
                    'media',
                    'table',
                    'help',
                    'wordcount',
                    'emoticons',
                    'autosave',
                    'autoresize',
                    'quickbars'
                ],
                toolbar: 'undo redo | formatselect | bold italic backcolor | ' +
                    'alignleft aligncenter alignright alignjustify | ' +
                    'bullist numlist outdent indent | removeformat | help',
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
            });
        }
    </script>

</div>