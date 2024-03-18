<div class="my-2 text-center border rounded bg-light p-2">
    <style>
        .btn-outline-success {
            border-color: green;
            background-color: white;
            color: green;
        }

        .btn-outline-success:hover {
            background-color: green;
            color: white;
        }

        .fa-arrow-right {
            color: inherit; /* Asegura que el ícono herede el color del texto del botón */
        }

        .select-group {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }
    </style>
    <div class="d-flex justify-content-center align-items-end gap-2 flex-wrap">
        <div class="select-group">
            <select wire:model="volumenSeleccionado" class="form-select form-select-sm">
                <option value="">Seleccione un Volumen</option>
                @foreach ($volumenes as $volumen)
                <option value="{{ $volumen->id }}">{{ $volumen->nombre }}</option>
                @endforeach
            </select>
            <button wire:click="navegar('volumen')" class="btn btn-sm btn-outline-success">
                <i class="fa fa-arrow-right"></i>
            </button>
        </div>
        
        <div class="select-group">
            <select wire:model="libroSeleccionado" class="form-select form-select-sm">
                <option value="">Seleccione un Libro</option>
                @foreach ($libros as $libro)
                <option value="{{ $libro->id }}">{{ $libro->nombre }}</option>
                @endforeach
            </select>
            <button wire:click="navegar('libro')" class="btn btn-sm btn-outline-success">
                <i class="fa fa-arrow-right"></i>
            </button>
        </div>

        <div class="select-group">
            <select wire:model="capituloSeleccionado" class="form-select form-select-sm">
                <option value="">Seleccione un Capítulo</option>
                @foreach ($capitulos as $capitulo)
                <option value="{{ $capitulo->id }}">{{ $capitulo->referencia }}</option>
                @endforeach
            </select>
            <button wire:click="navegar('capitulo')" class="btn btn-sm btn-outline-success">
                <i class="fa fa-arrow-right"></i>
            </button>
        </div>
    </div>
</div>
