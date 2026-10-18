window.initSummernote = function (selector = '.description', height = 500) {
    $(selector).summernote({
        height: height,
        lang: 'ja-JP',
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear', 'superscript', 'subscript']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });
};
