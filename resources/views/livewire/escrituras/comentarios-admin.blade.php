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
        let $editor = null;

        // Se ejecuta cuando se ha cargado el DOM
        document.addEventListener('DOMContentLoaded', function() {
            // Obtén versiculoId desde el atributo data del div que engloba el formulario.
            const versiculoId = document.querySelector('.px-5').getAttribute('data-versiculo-id');

            // Limpieza del formulario en el botón Limpiar
            window.addEventListener('clear-tinymce', event => {
                clearTinyMCE(versiculoId);
            });

            // Inicializa TinyMCE con el versiculoId correcto
            initializeTinyMCE(versiculoId);

            // Se ejecuta cuando se presiona una de las flechas de dirección
            Livewire.on('moved', () => {
                initializeTinyMCE(versiculoId);
            });
        });

        // Función para inicializar TinyMCE
       async function initializeTinyMCE(versiculoId) {
            console.log("Inicializando TinyMCE para", versiculoId);
            const editors = await tinymce.init({
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

            $editor = editors[0]; 
        }

        // Función para sincronizar el contenido de TinyMCE antes de enviar el formulario
        function synchronizeTinyMCE(versiculoId) {
            console.log("Sincronizando TinyMCE para", versiculoId);
            // Utiliza el id generado dinámicamente para encontrar y guardar el contenido de TinyMCE.
            if (tinymce.get(`comentario-${versiculoId}`)) {
                tinymce.get(`comentario-${versiculoId}`).save();
            }
        }

        // Función para borrar el contenido de TinyMCE
        function clearTinyMCE(versiculoId) {
            if ($editor) {
                document.getElementById(`titulo-${versiculoId}`).value = ''; // Limpia el título
                document.getElementById(`comentario-${versiculoId}`).value = ''; // Limpia el textarea
                tinyMCE.get(`comentario-${versiculoId}`).setContent(''); // Limpia el contenido de TinyMCE
            } else {
                console.log("El editor TinyMCE no está inicializado.");
            }
        }
    </script>
</div>