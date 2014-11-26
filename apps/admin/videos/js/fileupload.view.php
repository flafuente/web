<?php defined('_EXE') or die('Restricted access'); ?>

<script>
    $(function () {
        //File Upload
        $('#fileupload').fileupload({
            maxChunkSize: 10000000,
            url: "<?=Url::site('videos/upload');?>",
            formData: "",
            dataType: 'json',
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    if (!file.error) {
                        $('<p/>').text(file.name).appendTo('#files');
                        $("#filename").val(file.name);
                    } else {
                        $("#filename").val("");
                        alert(file.error);
                    }
                });
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        })
    });
</script>
