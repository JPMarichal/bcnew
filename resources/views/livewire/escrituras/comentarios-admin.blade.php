<div>
    <div>
        <button class="btn btn-primary mb-3" wire:click="clearForm()">Nuevo Comentario</button>

        <div class="px-5" data-versiculo-id="{{ $versiculoId }}">
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
                <button type="button" class="btn btn-warning btn-update" data-versiculo-id="{{ $versiculoId }}">Actualizar</button>
                @else
                <button type="button" class="btn btn-success btn-save" data-versiculo-id="{{ $versiculoId }}">Guardar</button>
                @endif
                <button type="button" class="btn btn-secondary" wire:click="clearForm()">Limpiar</button>
            </div>
        </div>

        <div class="mt-4">
            <div class="list-group" wire:key="comentarios-list-{{ $reRenderKey }}">
                @foreach($comentarios as $comentario)
                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" wire:key="comentario-{{ $comentario->id }}-{{ $reRenderKey }}">
                    <div>{{ $comentario->titulo }}</div>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-success" wire:click="moveUp({{ $comentario->id }})">
                            <i class="fas fa-arrow-up"></i>
                        </button>
                        <button class="btn btn-sm btn-success" wire:click="moveDown({{ $comentario->id }})">
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
            console.log('DOMContentLoaded');
            // Espera a que Livewire esté completamente cargado
            //  document.addEventListener('livewire:load', function() {
            console.log('livewire:load');
            // Obtén versiculoId desde el atributo data del div que engloba el formulario.
            const versiculoId = document.querySelector('.px-5').getAttribute('data-versiculo-id');
            console.log(versiculoId);

            // Inicializa TinyMCE con el versiculoId correcto
            initializeTinyMCE(versiculoId);

            // Se ejecuta cuando se presiona una de las flechas de dirección
            Livewire.on('moved', () => {
                initializeTinyMCE(versiculoId);
            });
            //   });

            document.body.addEventListener('click', function(event) {
                const versiculoId = document.querySelector('.px-5').getAttribute('data-versiculo-id');
                if (event.target.matches('.btn-update')) {
                    console.log('Actualizar');
                    // Botón actualizar
                    window.prepareAndSaveUpdate(versiculoId, true);
                } else if (event.target.matches('.btn-save')) {
                    console.log('Guardar');
                    // Botón guardar
                    window.prepareAndSaveUpdate(versiculoId, false);
                }
            });

            $(document).ready(function() {
                $('#accounts').on('click', '.btn-save', function(e) {
                    console.log('Click on save');
                    @this.call('initSaveComment', 33);
                });
            });

            // Función modificada para preparar y realizar el guardado/actualización
            window.prepareAndSaveUpdate = function(versiculoId, isUpdate) {
                synchronizeTinyMCE(versiculoId).then(() => {
                    if (isUpdate) {
                        @this.call('initUpdateComment');
                    } else {
                        @this.call('initSaveComment', tinymce.get(`comentario-${versiculoId}`).getContent());
                    }
                }).catch(error => console.error(error));
            };

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
                            editor.save();
                        });
                    }
                });

                $editor = editors[0];
            }

            // Función para sincronizar el contenido de TinyMCE antes de enviar el formulario
            function synchronizeTinyMCE(versiculoId) {
                return new Promise((resolve, reject) => {
                    const editor = tinymce.get(`comentario-${versiculoId}`);
                    if (editor) {
                        editor.save();
                        resolve(true); // Resuelve la promesa indicando que la sincronización fue exitosa.
                    } else {
                        reject(new Error("Editor TinyMCE no encontrado"));
                    }
                });
            }

            // Función para borrar el contenido de TinyMCE
            function clearTinyMCE(versiculoId) {
                if ($editor) {
                    document.getElementById(`titulo-${versiculoId}`).value = ''; // Limpia el título
                    document.getElementById(`comentario-${versiculoId}`).value = ''; // Limpia el textarea
                    tinyMCE.get(`comentario-${versiculoId}`).setContent(''); // Limpia el contenido de TinyMCE
                    initializeTinyMCE(versiculoId);
                }
            }
        });
    </script>

</div>