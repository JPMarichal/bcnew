document.addEventListener('DOMContentLoaded', function () {
    tinymce.init({
        selector: 'textarea',
        menubar: true,
        language: 'es',
        plugins: [
            'advlist',
            'autolink',
            'lists',
            'link',
            'image',
            'charmap',
            'preview',
            'anchor',
            'searchreplace',
            'code',
            'fullscreen',
            'media',
            'table',
            'help',
            'wordcount',
            'emoticons',
            'autosave',
            'autoresize',
            'quickbars'
        ],
        toolbar: 
            ['undo redo | formatselect | ' +
            'bold italic | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist | ' ,
            'link unlink image media table| ' +
            'emoticons | ' +
            'removeformat | '+
            'preview fullscreen | help ' +
            ' code'],
        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
        autosave_ask_before_unload: true,
        autosave_interval: "30s",
        autosave_retention: "2m",
        autoresize_bottom_margin: 50,
        end_container_on_empty_block: true,
        height: 300,
        min_height:300
    });

    document.querySelectorAll('form').forEach(function (form) {
        form.addEventListener('submit', function () {
            tinymce.triggerSave();
        });
    });
});
