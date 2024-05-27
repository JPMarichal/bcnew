<div class="mb-4">
    <input type="text" class="form-control" placeholder="Buscar..." wire:model.debounce.500ms="searchTerm">
    <button class="btn btn-primary mt-2" wire:click="search">Buscar</button>
</div>
