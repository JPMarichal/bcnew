document.addEventListener('DOMContentLoaded', function () {
    tinymce.init({
        selector: 'textarea',
        menubar: true,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview', 'anchor',
            'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table',  'code', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | formatselect | ' +
        'bold italic | alignleft aligncenter ' +
        'alignright alignjustify | bullist numlist outdent indent | ' +
        'removeformat | help | ' +
        'table | blockquote | ' +
        'h1 h2'
    });
});
