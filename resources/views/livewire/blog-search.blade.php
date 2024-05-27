<div class="mb-4 d-flex">
    <input type="text" class="form-control form-control-sm rounded-pill mr-2" placeholder="Escribe aquí para hacer una búsqueda..." wire:model.debounce.500ms="searchTerm" wire:keydown.enter="search">
    <button class="btn btn-primary btn-sm d-flex align-items-center" wire:click="search">
        <i class="fas fa-search"></i> Buscar
    </button>
</div>
