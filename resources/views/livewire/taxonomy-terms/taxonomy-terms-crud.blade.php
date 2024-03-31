<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <button wire:click="create()" class="btn btn-primary mb-3">Crear Nuevo Término</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Titulo</th>
                <th>Padre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($taxonomyTerms as $taxonomyTerm)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $taxonomyTerm->name }}</td>
                    <td>{{ $taxonomyTerm->parent }}</td>
                    <td>
                        <button wire:click="edit({{ $taxonomyTerm->id }})" class="btn btn-sm btn-info">Editar</button>
                        <button wire:click="delete({{ $taxonomyTerm->id }})"
                            class="btn btn-sm btn-danger">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $taxonomyTerms->links() }}

    @include('livewire.taxonomy-terms.create')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @this.on('triggerDelete', taxonomyTermId => {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'Este término será eliminado permanentemente.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar!'
                }).then((result) => {
                    // Si confirma la eliminación
                    if (result.isConfirmed) {
                        @this.call('delete', taxonomyTermId);
                        Swal.fire(
                            '¡Eliminado!',
                            'El término ha sido eliminado.',
                            'success'
                        )
                    }
                });
            });
        });
    </script>
</div>
