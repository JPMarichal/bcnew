document.addEventListener('DOMContentLoaded', function () {
    tinymce.init({
        selector: 'textarea',
        // Configuraciones globales básicas
        menubar: true,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount',
            'table', // Añade el plugin de tabla aquí
            'blockquote', // No es necesario añadirlo como plugin, pero sí asegurarte de que el botón esté en la toolbar si deseas un botón específico para blockquote
        ],
        toolbar: 'undo redo | formatselect | ' +
        'bold italic | alignleft aligncenter ' +
        'alignright alignjustify | bullist numlist outdent indent | ' +
        'removeformat | help | ' +
        'table | blockquote | ' + // Añade los botones de tabla y blockquote aquí
        'h1 h2 h3', // Añade botones para insertar encabezados
    });
});
