document.addEventListener('DOMContentLoaded', function () {
    tinymce.init({
        selector: 'textarea',  
        // Configuraciones globales básicas
        menubar: true, 
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
        ],
        toolbar: 'undo redo | formatselect | ' +
        'bold italic backcolor | alignleft aligncenter ' +
        'alignright alignjustify | bullist numlist outdent indent | ' +
        'removeformat | help'
    });
});
