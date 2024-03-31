<div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Listado de Taxonomías</h3>
                        <a href="{{ url('/taxonomies/manage') }}" class="btn btn-success">Agregar Nueva Taxonomía</a>
                    </div>
                    <div class="card-body">
                        @if($taxonomies->isEmpty())
                            <div class="alert alert-info">No hay taxonomías creadas aún. <a href="{{ url('/taxonomies/manage') }}">Crear una nueva taxonomía.</a></div>
                        @else
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Type</th>
                                        <th>Slug</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($taxonomies as $taxonomy)
                                        <tr>
                                            <td>{{ $taxonomy->id }}</td>
                                            <td>{{ $taxonomy->name }}</td>
                                            <td>{{ $taxonomy->type }}</td>
                                            <td>{{ $taxonomy->slug }}</td>
                                            <td>
                                                <button class="btn btn-primary btn-sm"
                                                    wire:click="edit({{ $taxonomy->id }})">Editar</button>
                                                <button class="btn btn-danger btn-sm"
                                                    wire:click="deleteTaxonomy({{ $taxonomy->id }})"
                                                    onclick="confirm('¿Está seguro que desea eliminar esta taxonomía?') || event.stopImmediatePropagation()">Eliminar</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $taxonomies->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>