<div>
    <div>
        <button class="btn btn-primary mb-3" wire:click="clearForm()">Nuevo Comentario</button>

        <div class="px-5" data-versiculo-id="{{ $versiculoId }}">
            <form wire:submit.prevent="saveComment">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="titulo-{{ $versiculoId }}" name="titulo-{{ $versiculoId }}" wire:model.defer="titulo" required>
                </div>
                <div class="mb-3" style="height: 40vh" wire:ignore>
                    <label for="comentario-{{ $versiculoId }}" class="form-label">Comentario</label>
                    <textarea class="form-control" id="comentario-{{ $versiculoId }}" name="comentario-{{ $versiculoId }}" rows="5" wire:model.defer="comentario"></textarea>
                </div>
                <div class="mb-3">
                    @if($comentarioId)
                    <button type="submit" class="btn btn-warning" onclick="synchronizeTinyMCE('{{ $versiculoId }}')">Actualizar</button>
                    @else
                    <button type="submit" class="btn btn-success" onclick="synchronizeTinyMCE('{{ $versiculoId }}')">Guardar</button>
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

    <style type="text/css">
        div.tox.tox-tinymce {
            height: 250px !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Obtén versiculoId desde el atributo data del div que engloba el formulario.
            const versiculoId = document.querySelector('.px-5').getAttribute('data-versiculo-id');

            window.addEventListener('clear-tinymce', event => {
                console.log('Sí paso por el listener de clear-tinymce');
                clearTinyMCE(versiculoId);
            });

            // Inicializa TinyMCE con el versiculoId correcto
            initializeTinyMCE(versiculoId);

            Livewire.on('moved', () => {
                // Si necesitas reinicializar TinyMCE después de eventos Livewire, asegúrate de pasar el versiculoId.
                initializeTinyMCE(versiculoId);
            });
        });

        // Función para inicializar TinyMCE
        function initializeTinyMCE(versiculoId) {
            console.log("Inicializando TinyMCE para", versiculoId);
            tinymce.init({
                selector: `#comentario-${versiculoId}`,
                menubar: true,
                language: 'es',
                height: '100%',
                plugins: [
                    'advlist', 'autolink', 'autosave', 'lists', 'link', 'image',
                    'charmap', 'preview', 'anchor', 'searchreplace', 'visualblocks',
                    'code', 'fullscreen', 'insertdatetime', 'media', 'table', 'help',
                    'wordcount', 'emoticons', 'autosave', 'autoresize', 'quickbars'
                ],
                toolbar: 'undo redo | formatselect | bold italic backcolor | ' +
                    'alignleft aligncenter alignright alignjustify | ' +
                    'bullist numlist outdent indent | removeformat | help',
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
                setup: function(editor) {
                    editor.on('change', function() {
                        // Asegura que los cambios en el editor se guarden en el textarea.
                        editor.save();
                    });
                }
            });
        }

        // Función para sincronizar el contenido de TinyMCE antes de enviar el formulario
        function synchronizeTinyMCE(versiculoId) {
            console.log("Sincronizando TinyMCE para", versiculoId);
            // Utiliza el id generado dinámicamente para encontrar y guardar el contenido de TinyMCE.
            if (tinymce.get(`comentario-${versiculoId}`)) {
                tinymce.get(`comentario-${versiculoId}`).save();
            }
        }

        function clearTinyMCE(versiculoId) {
            console.log("Limpiando TinyMCE para", versiculoId);

            console.log('Limpiando titulo ', versiculoId);
            document.getElementById(`titulo-${versiculoId}`).value = '';
            /*
                        if (tinymce.get(`comentario-${versiculoId}`)) {
                            console.log('Limpiando comentario');
                            tinymce.get(`comentario-${versiculoId}`).setContent('');
                        }*/
        }
    </script>
</div>