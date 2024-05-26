<div>
    <div class="btn-group" role="group">
        @livewire('print-button', ['postId' => $post->id])
        @livewire('export-pdf-button', ['postId' => $post->id])
    </div>
    @push('scripts')
        <script>
            window.addEventListener('print', event => {
                const printWindow = window.open('/print-view');
                printWindow.onload = function() {
                    printWindow.print();
                }
            });
        </script>
    @endpush
</div>
