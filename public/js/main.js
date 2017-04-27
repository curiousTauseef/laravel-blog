if(jQuery().select2) {
    $('.select2').select2();
}

if (typeof(tinyMCE) != "undefined") {
    tinymce.init({
        selector: "textarea",
        plugins: "link code"
    });

    $('input[type=submit]').on('click', function() {
        var content = tinymce.activeEditor.getContent();
        $('textarea').text('content');
    });    
}
