<div class="{{ $esPar ? 'versiculo-par' : '' }}">
    <strong>{{ $versiculo->num_versiculo }}</strong> {{ $versiculo->contenido }}
    @if($versiculo->comentarios()->exists())
        <button class="btn btn-sm" style="background-color: transparent;" onclick="mostrarComentarios({{ $versiculo->id }})">
            <i class="fas fa-lightbulb" style="color: orange;"></i>
        </button>
    @endif
</div>

<script>
function mostrarComentarios(versiculoId) {
    // Aquí puedes agregar la lógica para mostrar los comentarios.
    // Por ejemplo, abrir un modal con los comentarios o navegar a una sección de comentarios.
    console.log("Mostrar comentarios para el versículo " + versiculoId);
}
</script>
