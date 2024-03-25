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
            <h2 id="libro_seleccionado">[{{ $this->libro->id}}] {{ $this->libro->nombre ?? '' }}</h2>            
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
            <div class="row" style="font-weight: bold;">
                <div class="col-8 border">Parte</div>
                <div class="col-1 border text-center">Inicial</div>
                <div class="col-1 border text-center">Final</div>
                <div class="col-1 border bg-dark">&nbsp;</div>
                <div class="col-1 border bg-dark">&nbsp;</div>
            </div>
            @foreach ($partes as $parte)
            <div class="row">
                <div class="col-8 border">{{ $parte->nombre }}</div>
                <div class="col-1 border text-center">
                    <a href="{{ route('capitulos.show',$parte->capitulos->first()->referencia)}}" style="text-decoration: none;" target="_blank">
                    {{ $parte->capitulos->first()->num_capitulo ?? '' }}
                    </a>
                </div>
                <div class="col-1 border text-center">{{ $parte->capitulos->last()->num_capitulo ?? '' }}</div>
                <div class="col-1 border text-center">
                    <button class="btn btn-sm p-0" style="color: green;" wire:click="editar({{ $parte->id }})" title="Editar esta parte">
                        <i class="fa fa-edit"></i>
                    </button>
                </div>
                <div class="col-1 border text-center">
                    <button class="btn btn-sm p-0" style="color: red;" wire:click="eliminar({{ $parte->id }})" title="Eliminar esta parte">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>