<div>
    <h1>Administración de Temas</h1>
    <p>Administra tus temas desde aquí.</p>
    <ul id="sortable-list">
        @foreach ($temas as $tema)
            <li wire:key="tema-{{ $tema->id }}" data-id="{{ $tema->id }}" class="row border rounded mb-1">
                <div class="col-10">
                <span class="glyphicon glyphicon-move" aria-hidden="true"></span> 
                {{ $tema->titulo }}
                </div>
                <div class="col-2">
                <!-- Botón para editar el tema -->
                <button wire:click="edit({{ $tema->id }})">
                <i class="fas fa-edit"></i>
                </button>
                </div>
            </li>
        @endforeach
    </ul>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.10.2/Sortable.min.js"></script>
<script>
    document.addEventListener('livewire:load', function() {
        var el = document.getElementById('sortable-list');
        var sortable = new Sortable(el, {
            animation: 150,
            onEnd: function(evt) {
                var itemEl = evt.item; // Elemento movido
                Livewire.emit('updateOrder', evt.oldIndex, evt.newIndex);
            }
        });
    });
</script>
@endpush
