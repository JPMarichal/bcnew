<div class="{{ $esPar ? 'versiculo-par' : '' }}">
    <strong>{{ $versiculo->num_versiculo }}</strong> {{ $versiculo->contenido }}
    @if($versiculo->comentarios->isNotEmpty())
    <button class="btn btn-sm" style="background-color: transparent;" data-bs-toggle="modal" data-bs-target="#comentariosModal-{{ $versiculo->id }}">
        <i class="fas fa-lightbulb" style="color: orange;"></i>
    </button>

    <!-- Modal para Comentarios específico de cada versículo -->
    <div class="modal fade" id="comentariosModal-{{ $versiculo->id }}" tabindex="-1" aria-labelledby="comentariosModalLabel-{{ $versiculo->id }}" aria-hidden="true">
        <div class="modal-dialog modal-xl" style="max-width: 85%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="comentariosModalLabel-{{ $versiculo->id }}">Comentarios del Versículo {{ $versiculo->num_versiculo }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                    @foreach($versiculo->comentarios as $comentario)
                    <div>
                        <h5>{{ $comentario->titulo }}</h5>
                        {!! $comentario->comentario !!}
                    </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>