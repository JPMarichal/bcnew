<div>
    <div>
        @if($this->libro == null)
        <div class="alert alert-info" role="alert">
            <i class="fa fa-info-circle"></i> Selecciona un libro de las escrituras para ver sus partes y modificarlas.
        </div>
        @endif
        <div class="text-small mb-3 row">
            <div class="col-3 text-end">Selecciona un libro: </div>
            <div class="col-9">
            <select wire:change="cambiarLibro($event.target.value)" class="form-control text-small" style="width:200px">
                <option value="">Seleccione un libro</option>
                @foreach ($libros as $libro)
                <option value="{{ $libro->id }}">{{ $libro->nombre }}</option>
                @endforeach
            </select>
            </div>
        </div>
    </div>
    @if($this->libro != null)
    <div class="card">
        <div class="card-header text-center">
        <h2 id="libro_seleccionado">{{ $this->libro->nombre ?? '' }}</h2>
        </div>
        <div class="card-body">
            <input type="text" wire:model="titulo" placeholder="Título de la parte">
            <button wire:click="guardar">Guardar</button>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header text-center">
           <h3>Estructura del libro de {{ $this->libro->nombre }}</h3>
        </div>
        <div class="card-body">
            @foreach ($partes as $parte)
            <div class="row">
            <div class="col-8">{{ $parte->nombre }}</div>
            <div class="col-1">cap_inicial</div>
            <div class="col-1">cap_final</div>
            <div class="col-1">editar</div>
            <div class="col-1">eliminar</div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>