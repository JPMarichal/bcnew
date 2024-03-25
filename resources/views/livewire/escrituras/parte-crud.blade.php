<div>
    <div class="card">
        <div class="card-header row">
            <div class="col-4">
                <select wire:model="libro_id">
                    <option value="">Seleccione un libro</option>
                    @foreach ($libros as $libro)
                    <option value="{{ $libro->id }}">{{ $libro->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-8">
                <h2 id="libro_seleccionado">{{ $this->libro->nombre ?? 'Seleccione un libro' }}</h2>
            </div>
        </div>
        <div class="card-body">
            <input type="text" wire:model="titulo" placeholder="Título de la parte">
            
            <button wire:click="guardar">Guardar</button>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header">
            Lista de Partes
        </div>
        <div class="card-body">
            @foreach ($partes as $parte)
            <div>{{ $parte->nombre }}</div>
            @endforeach
        </div>
    </div>
</div>