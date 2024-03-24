<div class="{{ $esPar ? 'versiculo-par' : '' }}" id="{{ $versiculo->num_versiculo }}">
    {{-- Despliegue del versículo --}}
    <strong>{{ $versiculo->num_versiculo }}</strong> 
    {{ $versiculo->contenido }}

    @if($versiculo->comentarios->isNotEmpty())
    <button class="btn btn-sm" style="background-color: transparent;" data-bs-toggle="modal" data-bs-target="#comentariosModal-{{ $versiculo->id }}" title="Ver comentarios a {{$versiculo->referencia}}">
        <i class="fas fa-lightbulb" style="color: orange;"></i>
    </button>
    @endif

    @auth
    @if(auth()->user()->hasRole('Administrador'))
    <!-- Botón para funcionalidades de administración de comentarios (CRUD) -->
    <a href="{{ route('versiculos.comentarios.admin', $versiculo->referencia) }}" target="_blank" class="btn btn-sm mx-0 px-0" style="background-color: transparent;" title="Editar comentarios">
        <i class="fas fa-pencil-alt" style="color: #94c9c9;"></i>
    </a>
    @endif
    @endauth

    <!-- Modal para visualizar comentarios -->
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
</div>