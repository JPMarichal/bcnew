<button wire:click="print" class="btn btn-sm btn-primary" title="Imprimir">
    <i class="fas fa-print"></i>
</button>

@push('scripts')
    <script>
        window.addEventListener('print', event => {
            const url = event.detail[0].url;
            console.log('URL:', url); // Añadido para depuración
            const printWindow = window.open(url, '_blank');
            printWindow.onload = function() {
                printWindow.print();
            };
        });
    </script>
@endpush
