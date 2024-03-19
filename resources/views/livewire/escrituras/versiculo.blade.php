<div class="{{ $esPar ? 'versiculo-par' : '' }}">
    <strong>{{ $versiculo->num_versiculo }}</strong> {{ $versiculo->contenido }}
    @if($versiculo->comentarios->isNotEmpty())
    <button class="btn btn-sm" style="background-color: transparent;" data-bs-toggle="modal" data-bs-target="#comentariosModal-{{ $versiculo->id }}" title="Ver comentarios a {{$versiculo->referencia}}">
        <i class="fas fa-lightbulb" style="color: orange;"></i>
    </button>
    @endif

    @auth
    @if(auth()->user()->hasRole('Administrador'))
    <!-- Botón para abrir modal de agregar comentario -->
    <button class="btn btn-sm" style="background-color: transparent;" wire:click="abrirModal" title="Agregar comentario">
        <i class="fas fa-plus" style="color: #94c9c9;"></i>
    </button>

    <!-- Botón para funcionalidades de administración de comentarios (CRUD) -->
    <button class="btn btn-sm mx-0 px-0" style="background-color: transparent;" title="Editar comentarios de {{$versiculo->referencia}}">
        <i class="fas fa-pencil-alt" style="color: #94c9c9;"></i>
    </button>
    @endif
    @endauth

    <!-- Modal existente para visualizar comentarios -->
    <div class="modal fade" id="comentariosModal-{{ $versiculo->id }}" tabindex="-1" aria-labelledby="comentariosModalLabel-{{ $versiculo->id }}" aria-hidden="true">
        <div class="modal-dialog modal-xl" style="max-width: 85%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="comentariosModalLabel-{{ $versiculo->id }}">Comentarios a {{ $versiculo->referencia }}</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                    @foreach($versiculo->comentarios as $comentario)
                    <div class="border rounded p-3 mb-2">
                        <h4 class="mb-2" style="border-bottom: 1px solid brown">{{ $comentario->titulo }}</h4>
                        <div class="px-3">{!! $comentario->comentario !!}</div>
                    </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para agregar nuevo comentario, controlado por atributos de Bootstrap -->
    @if($mostrarModal)
    <!-- Modal para agregar nuevo comentario -->
    <div class="modal fade show d-block" id="agregarComentarioModal-{{ $versiculo->id }}" tabindex="-1" aria-labelledby="agregarComentarioModalLabel-{{ $versiculo->id }}" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarComentarioModalLabel">Agregar Comentario</h5>
                    <button type="button" class="btn-close" wire:click="cerrarModal" aria-label="Cerrar"></button>
                </div>
                <form wire:submit.prevent="guardarComentario">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="titulo-{{ $versiculo->id }}" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo-{{ $versiculo->id }}" wire:model.defer="nuevoComentarioTitulo" required>
                        </div>
                        <div class="mb-3">
                            <label for="comentario-{{ $versiculo->id }}" class="form-label">Comentario</label>
                            <textarea class="form-control livewire-ignore" id="comentario-{{ $versiculo->id }}" name="comentario-{{ $versiculo->id }}" rows="5" wire:model.defer="nuevoComentarioContenido"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="cerrarModal">
                            <i class="fa fa-close" aria-hidden="true"></i> Cerrar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save" aria-hidden="true"></i> Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div> <!-- Asegúrate de que este div solo se renderice junto con el modal -->
    @endif

    <script>
        document.addEventListener('livewire:load', function() {
            function inicializarTinyMCE() {
                // Asegúrate de destruir cualquier instancia previa para evitar duplicados
                if (tinymce.get('comentario-{{ $versiculo->id }}')) {
                    tinymce.get('comentario-{{ $versiculo->id }}').remove();
                }

                // Inicializa TinyMCE en el textarea
                tinymce.init({
                    selector: '#comentario-{{ $versiculo->id }}',
                    // Tus opciones de configuración de TinyMCE aquí...
                    setup: function(editor) {
                        editor.on('Change', function(e) {
                            // Actualiza manualmente el valor del textarea para que Livewire lo detecte
                            @this.set('nuevoComentarioContenido', editor.getContent());
                        });
                    }
                });
            }

            window.livewire.on('mostrarModal', () => {
                inicializarTinyMCE();
            });

            // Opcional: Si el modal se muestra inmediatamente al cargar la página, inicializa TinyMCE directamente.
            inicializarTinyMCE();
        });
    </script>
</div>