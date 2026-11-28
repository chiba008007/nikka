$(function () {

    // 説明文をリッチテキストエディタにする
    $('.description').summernote({
        height: 250,
        lang: 'ja-JP',
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
            ['font', ['fontsize', 'color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link']],
            ['view', ['codeview']]
        ]
    });
    $('.descriptionShort').summernote({
        height: 45,
        lang: 'ja-JP',
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
            ['font', ['fontsize', 'color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link']],
            ['view', ['codeview']]
        ]
    });
    $(".editbtn").click(function () {
        var id = $(this).attr("id").split("-")[1];
        var val = $("#edit-" + id).val();

        $.ajax({
            url: "/edit/top/edit",
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                num: id,
                note: val
            },
            success: function () {
                $("#t-display" + id).html(val);
            },
            error: function (xhr) {
                alert("更新に失敗しました。");
                console.error(xhr.responseText);
            }
        });
    });
});
