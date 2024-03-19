document.addEventListener('DOMContentLoaded', function () {
    // Inicialización global de TinyMCE para todos los textarea excepto aquellos marcados para ser ignorados
    tinymce.init({
        selector: 'textarea:not(.livewire-ignore)', // Ignora los textarea con clase .livewire-ignore
        menubar: true,
        language: 'es',
        plugins: [
            'advlist autolink lists link image charmap preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount emoticons',
            'autosave autoresize quickbars'
        ],
        toolbar: 'undo redo | formatselect | ' +
        'bold italic backcolor | alignleft aligncenter ' +
        'alignright alignjustify | bullist numlist outdent indent | ' +
        'removeformat | help',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
    });

    // Función específica para re-inicializar TinyMCE para textareas en modales de Livewire
    window.inicializarTinyMCEParaLivewire = function(id) {
        // Asegurarse de destruir cualquier instancia anterior para evitar duplicados
        if (tinymce.get(id)) {
            tinymce.get(id).remove();
        }
    
        // Inicializar TinyMCE específicamente para el textarea indicado
        tinymce.init({
            selector: '#' + id,
            menubar: true,
            language: 'es',
            plugins: [
                'advlist autolink lists link image charmap preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount emoticons',
                'autosave autoresize quickbars'
            ],
            toolbar: 'undo redo | formatselect | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
    }
});
