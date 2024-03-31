<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save">
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" id="name" wire:model="name"
                placeholder="Ingresa el nombre de la taxonomía">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="type">Tipo</label>
            <input type="text" class="form-control" id="type" wire:model="type"
                placeholder="Ingresa el tipo de la taxonomía">
            @error('type') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-3">Guardar</button>
    </form>
</div>
