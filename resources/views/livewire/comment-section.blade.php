<div class="border rounded p-3 mx-3">
    <h2>Comparte tu opinión</h2>
    
    <!-- Formulario para agregar comentarios -->
    <form wire:submit.prevent="addComment">
        @csrf
        <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" class="form-control" wire:model.defer="name" id="name">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="email">Correo electrónico:</label>
            <input type="email" class="form-control" wire:model.defer="email" id="email">
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="content">Comentario:</label>
            <textarea class="form-control" wire:model.defer="content" id="content"></textarea>
            @error('content') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-primary mt-2">Agregar opinión</button>
    </form>

    <!-- Lista de comentarios -->
    @foreach($comments as $comment)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $comment->author }}</h5>
                <p class="card-text">{{ $comment->content }}</p>
                <!-- Agregar metadatos como fecha y hora -->
                <p class="card-text"><small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small></p>
                <!-- Verificar si el comentario es del usuario actual -->
                @if($isUserComment($comment->user_id))
                    <p class="card-text"><small class="text-muted">Este es tu comentario</small></p>
                @endif
                <!-- Recursión para mostrar comentarios anidados -->
                @foreach($comment->replies as $reply)
                    <div class="ml-4">
                        <h6 class="card-subtitle mb-2 text-muted">{{ $reply->author }}</h6>
                        <p class="card-text">{{ $reply->content }}</p>
                        <!-- Agregar metadatos y verificar usuario como se hizo anteriormente -->
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

