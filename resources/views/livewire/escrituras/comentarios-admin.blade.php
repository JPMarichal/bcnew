<div>
    <div>
        <!-- Editor -->
        <div class="px-5 border rounded" data-versiculo-id="{{ $versiculoId }}">
            <h3 class="text-center mb-3" style="background-color:gainsboro">Editor</h3>
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
                <button type="button" class="btn btn-secondary" onclick="clearTinyMCE('{{ $versiculoId }}')">Limpiar</button>
            </div>
        </div>

        <!-- Grid -->
        <div class="mt-4 border rounded p-3">
            <h3 class="text-center mb-3" style="background-color:gainsboro">Listado de comentarios</h3>
            <div class="text-end">
                <button class="btn btn-primary btn-sm mb-3" onclick="clearTinyMCE('{{ $versiculoId }}')">
                    <i class="fas fa-plus"></i> Nuevo Comentario
                </button>
            </div>
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
                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalConfirmDelete" onclick="setCommentIdToDelete({{ $comentario->id }}, '{{ $comentario->titulo }}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Modal de Confirmación para Eliminar Comentario -->
        <div class="modal fade" id="modalConfirmDelete" tabindex="-1" aria-labelledby="modalConfirmDeleteLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalConfirmDeleteLabel">Confirmar Eliminación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de que quieres eliminar este comentario?
                        <ul>
                            <li></li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="confirmDelete">Eliminar</button>
                    </div>
                </div>
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

            // Inicializa TinyMCE con el versiculoId correcto
            initializeTinyMCE(versiculoId);

            // Se ejecuta cuando se presiona una de las flechas de dirección
            Livewire.on('moved', () => {
                initializeTinyMCE(versiculoId);
            });
            //   });

            // Se ejecuta cuando se presiona
            document.body.addEventListener('click', function(event) {
                const versiculoId = document.querySelector('.px-5').getAttribute('data-versiculo-id');
                if (event.target.matches('.btn-update')) {
                    // Botón actualizar
                    window.prepareAndSaveUpdate(versiculoId, true);
                } else if (event.target.matches('.btn-save')) {
                    // Botón guardar
                    window.prepareAndSaveUpdate(versiculoId, false);
                }
            });

            // Prepara y realiza el guardado o actualización
            window.prepareAndSaveUpdate = function(versiculoId, isUpdate) {
                synchronizeTinyMCE(versiculoId).then(() => {
                    if (isUpdate) {
                        @this.call('initUpdateComment', tinymce.get(`comentario-${versiculoId}`).getContent());
                        clearTinyMCE(versiculoId);
                    } else {
                        @this.call('initSaveComment', tinymce.get(`comentario-${versiculoId}`).getContent());
                        clearTinyMCE(versiculoId);
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

            // Función para borrar el contenido del formulario
            window.clearTinyMCE = function(versiculoId) {
                // Limpiar el título
                const tituloInput = document.getElementById(`titulo-${versiculoId}`);
                if (tituloInput) {
                    tituloInput.value = '';
                }

                // Limpiar el textarea (por si acaso no estás usando TinyMCE o para asegurar que esté vacío)
                const comentarioTextarea = document.getElementById(`comentario-${versiculoId}`);
                if (comentarioTextarea) {
                    comentarioTextarea.value = '';
                }

                // Limpiar TinyMCE
                if (tinymce.get(`comentario-${versiculoId}`)) {
                    tinymce.get(`comentario-${versiculoId}`).setContent('');
                }

                initializeTinyMCE(versiculoId);

                // Restablece las propiedades
                @this.set('comentarioId', null);
                @this.set('titulo', '');
                @this.set('comentario', '');
            }
        });

        function setCommentIdToDelete(id, titulo) {
            console.log(titulo);
            // Asigna el ID del comentario al botón de confirmación dentro del modal
            document.getElementById('confirmDelete').setAttribute('data-comment-id', id);

            // Actualiza el contenido del <li> con el título del comentario
            document.querySelector('#modalConfirmDelete .modal-body ul li').textContent = titulo;
        }

        document.getElementById('confirmDelete').addEventListener('click', function() {
            const commentId = this.getAttribute('data-comment-id');
            // Llama al método de Livewire para eliminar el comentario
            @this.call('deleteComment', commentId);

            // Opcional: Ocultar el modal manualmente después de confirmar
            $('#modalConfirmDelete').modal('hide');
        });
    </script>

</div>