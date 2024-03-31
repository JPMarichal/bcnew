<!-- Modal -->
<div class="modal fade" id="taxonomyTermModal" tabindex="-1" aria-labelledby="taxonomyTermModalLabel" aria-hidden="true"
    wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taxonomyTermModalLabel">
                    {{ $taxonomyTermId ? 'Editar Término' : 'Crear Término' }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form wire:submit.prevent="store">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" wire:model="name"
                            placeholder="Ingresa el nombre">
                        @error('name')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="taxonomyId">Taxonomía</label>
                        <select class="form-control" id="taxonomyId" wire:model="taxonomyId">
                            <option value="">Seleccione una Taxonomía</option>
                            @foreach ($taxonomies as $taxonomy)
                                <option value="{{ $taxonomy->id }}">{{ $taxonomy->name }}</option>
                            @endforeach
                        </select>
                        @error('taxonomyId')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="parentId">Término Padre (opcional)</label>
                        <select class="form-control" id="parentId" wire:model="parentId">
                            <option value="">Ninguno</option>
                            @foreach ($possibleParents as $term)
                                <option value="{{ $term->id }}">{{ $term->name }}</option>
                            @endforeach
                        </select>
                        @error('parentId')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit"
                        class="btn btn-primary">{{ $taxonomyTermId ? 'Actualizar' : 'Guardar' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    Livewire.on('openModal', () => {
        $('#taxonomyTermModal').modal('show');
    });

    window.addEventListener('close-modal', event => {
        $('#taxonomyTermModal').modal('hide');
    });
</script>
