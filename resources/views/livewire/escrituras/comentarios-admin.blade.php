<div>
    <div>
        <!-- Editor -->
        <div class="px-5 border rounded" data-versiculo-id="{{ $versiculoId }}">
            <h3 class="text-center mb-3" style="background-color:gainsboro" title="Aquí puedes crear un nuevo comentario o editar uno existente.">Editor</h3>
            <div class="mb-3">
                <label for="titulo" class="form-label" title="Escribe aquí el título de tu comentario">Título</label>
                <input type="text" class="form-control" id="titulo-{{ $versiculoId }}" name="titulo-{{ $versiculoId }}" wire:model.defer="titulo" title="Escribe aquí el título de tu comentario" required>
            </div>
            <div class="mb-3" style="height: 40vh" wire:ignore>
                <label for="comentario-{{ $versiculoId }}" class="form-label" title="Escribe aquí el contenido de tu comentario">Comentario</label>
                <textarea class="form-control" id="comentario-{{ $versiculoId }}" name="comentario-{{ $versiculoId }}" rows="5" wire:model.defer="comentario"></textarea>
            </div>
            <div class="mb-3">
                <button type="button" class="btn btn-secondary" onclick="clearTinyMCE('{{ $versiculoId }}')" title="Limpia el formulario">
                    <i class="fas fa-eraser"></i> Limpiar
                </button>
                @if($comentarioId)
                <button type="button" class="btn btn-warning btn-update" data-versiculo-id="{{ $versiculoId }}" title="Guarda el comentario editado">
                    <i class="fas fa-edit"></i> Actualizar
                </button>
                @else
                <button type="button" class="btn btn-success btn-save" data-versiculo-id="{{ $versiculoId }}" title="Guarda el nuevo comentario">
                    <i class="fas fa-save"></i> Guardar
                </button>
                @endif
            </div>

        </div>

        <!-- Grid -->
        <div class="mt-4 border rounded p-3">
            <h3 class="text-center mb-3" style="background-color:gainsboro" title="Aquí se muestran todos los comentarios asociados a este versículo. Puedes reordenarlos, editarlos o eliminarlos.">Listado de comentarios</h3>
            <div class="text-end">
                <button class="btn btn-primary btn-sm mb-3" onclick="clearTinyMCE('{{ $versiculoId }}')" title="Prepara el formulario para agregar un nuevo comentario">
                    <i class="fas fa-plus"></i> Nuevo Comentario
                </button>
            </div>
            <div class="list-group" wire:key="comentarios-list-{{ $reRenderKey }}">
                @foreach($comentarios as $comentario)
                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" wire:key="comentario-{{ $comentario->id }}-{{ $reRenderKey }}">
                    <div>{{ $comentario->titulo }}</div>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-success" wire:click="moveUp({{ $comentario->id }})" title="Subir comentario">
                            <i class="fas fa-arrow-up"></i>
                        </button>
                        <button class="btn btn-sm btn-success" wire:click="moveDown({{ $comentario->id }})" title="Bajar comentario">
                            <i class="fas fa-arrow-down"></i>
                        </button>
                        <button class="btn btn-sm btn-info" wire:click="edit({{ $comentario->id }})" title="Editar comentario">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalConfirmDelete" onclick="setCommentIdToDelete({{ $comentario->id }}, '{{ $comentario->titulo }}')" title="Eliminar comentario">
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

            const tituloInput = document.getElementById(`titulo-{{ $versiculoId }}`);

            // Inicializa TinyMCE con el versiculoId correcto
            initializeTinyMCE(versiculoId);

            // Se ejecuta cuando se presiona una de las flechas de dirección
            Livewire.on('moved', () => {
                initializeTinyMCE(versiculoId);
            });
            //   });

            window.addEventListener('editing-comment', function() {
                const versiculoId = document.querySelector('.px-5').getAttribute('data-versiculo-id');
                const tituloInput = document.getElementById(`titulo-${versiculoId}`);
                tituloInput.value = event.detail[0].titulo;
                tinymce.get(`comentario-${versiculoId}`).setContent(event.detail[0].comentario);

                // Oculta el botón Guardar y muestra el botón Actualizar
                document.querySelector('.btn-save').style.display = 'none';
                document.querySelector('.btn-update').style.display = 'inline-block';
            });

            window.addEventListener('reset-form', function() {
                // Muestra el botón Guardar y oculta el botón Actualizar
                document.querySelector('.btn-save').style.display = 'inline-block';
                document.querySelector('.btn-update').style.display = 'none';
            });

            // Se ejecuta cuando se presiona el botón Guardar o Actualizar
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

            // Añade manejadores de eventos para input y paste
            tituloInput.addEventListener('input', handleTitleChange);
            tituloInput.addEventListener('paste', handleTitleChange);

            // Función para manejar cambios en el campo de título
            function handleTitleChange(event) {
                // Temporizador para manejar el contenido pegado correctamente
                setTimeout(() => {
                    let value = event.target.value;
                    // Elimina cualquier punto final
                    value = value.replace(/\.$/, '');
                    // Convierte la primera letra en mayúscula
                    value = value.charAt(0).toUpperCase() + value.slice(1);
                    // Actualiza el valor del campo de título
                    event.target.value = value;
                }, 1);
            }

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
                        'wordcount', 'emoticons', 'autosave', 'quickbars'
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