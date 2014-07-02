<?php defined('_EXE') or die('Restricted access'); ?>

<?php
//Toolbar
if ($video->id) {
    $subtitle = "Editar vídeo";
    $title = "Guardar";
} else {
    $subtitle = "Nuevo vídeo";
    $title = "Crear";
}
Toolbar::addTitle("Vídeos", "facetime-video", $subtitle);
if ($video->id) {
    //Delete button
    Toolbar::addButton(
        array(
            "title" => "Eliminar",
            "app" => "videos",
            "action" => "delete",
            "class" => "danger",
            "spanClass" => "remove",
            "confirmation" => "¿Deseas realmente eliminar este vídeo?",
        )
    );
}
//Cancel button
Toolbar::addButton(
    array(
        "title" => "Cancelar",
        "app" => "videos",
        "action" => "index",
        "class" => "primary",
        "spanClass" => "chevron-left",
        "noAjax" => true,
    )
);
//Save button
Toolbar::addButton(
    array(
        "title" => $title,
        "app" => "videos",
        "action" => "save",
        "class" => "success",
        "spanClass" => "ok",
    )
);
Toolbar::render();
?>

<form method="post" name="mainForm" id="mainForm" action="<?=Url::site();?>" class="form-horizontal ajax" role="form" autocomplete="off">
    <input type="hidden" name="router" id="router" value="admin">
    <input type="hidden" name="app" id="app" value="videos">
    <input type="hidden" name="action" id="action" value="">
    <input type="hidden" name="id" value="<?=$video->id?>">
    <div class="row">
        <div class="col-md-<?php echo $video->id ? 6 : 12; ?>">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Detalles
                </div>
                <div class="panel-body">
                    <!-- Usuario -->
                    <?php if ($video->userId) { ?>
                        <?php $user = new User($video->userId); ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                Usuario
                            </label>
                            <div class="col-sm-8">
                                <p class="form-control-static">
                                    <a href="<?=Url::site("admin/users/edit/".$user->id);?>">
                                        <?=Helper::sanitize($user->getFullName());?>
                                    </a>
                                </p>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- Estado -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Estado
                        </label>
                        <div class="col-sm-8">
                            <input type="hidden" name="estadoId" value="0">
                            <input type="checkbox" class="switch" name="estadoId" id="estadoId" value="1" <?php if($video->estadoId) echo "checked";?>>
                        </div>
                    </div>
                    <?php if (count($categorias)) { ?>
                        <!-- Categoría -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                Categoría
                            </label>
                            <div class="col-sm-8">
                                <?=HTML::select("categoriaId", $categorias, $video->categoriaId, null, null, array("display" => "nombre")); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- Título -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Título
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="titulo" name="titulo" class="form-control" value="<?=Helper::sanitize($video->titulo);?>">
                        </div>
                    </div>
                    <!-- Descripción -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Descripción
                        </label>
                        <div class="col-sm-8">
                            <textarea id="descripcion" name="descripcion" class="form-control"><?=Helper::sanitize($video->descripcion);?></textarea>
                        </div>
                    </div>
                    <?php if (count($tags)) { ?>
                        <!-- Tags -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                Tags
                            </label>
                            <div class="col-sm-8">
                                <?php $currentTags = Tag::getTagsIdsByVideoId($video->id); ?>
                                <?=HTML::select("tags[]", $tags, $currentTags, array("class" => "select2", "multiple" => "true"), null, array("display" => "nombre")); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- Archivo -->
                    <?php if (!$video->id) { ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                Archivo
                            </label>
                            <div class="col-sm-8">
                                <input type="hidden" name="file" id="filename" value="">
                                <input id="fileupload" type="file" class="btn-primary btn" name="files[]" accept="video/*">
                                <br>
                                <br>
                                <!-- The global progress bar -->
                                <div id="progress" class="progress">
                                    <div class="progress-bar progress-bar-success"></div>
                                </div>
                                <!-- The container for the uploaded files -->
                                <div id="files" class="files"></div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php if ($video->id) { ?>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Archivos
                    </div>
                    <div class="panel-body">
                        <?php if (is_array($videosArchivos)) { ?>
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Estado</th>
                                        <th>Archivo</th>
                                        <th>Tamaño</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($videosArchivos as $videoArchivo) { ?>
                                        <tr>
                                            <td><?=$videoArchivo->id;?></td>
                                            <td>
                                                <span class="label label-<?=$videoArchivo->getEstadoCssString();?>">
                                                    <?=$videoArchivo->getEstadoString();?>
                                                </span>
                                            </td>
                                            <td><?=Helper::sanitize($videoArchivo->file);?></td>
                                            <td><?=$videoArchivo->getSizeString();?></td>
                                            <td>
                                                <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#archivo<?=$videoArchivo->id;?>">
                                                    <span class="glyphicon glyphicon-play"></span>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</form>

<?php if (is_array($videosArchivos)) { ?>
    <?php foreach ($videosArchivos as $videoArchivo) { ?>
        <div class="modal fade" id="archivo<?=$videoArchivo->id;?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Archivo #<?=$videoArchivo->id;?></h4>
                    </div>
                    <div class="modal-body form-horizontal" role="form">
                        <div class="form-group">
                            <center>
                                <video id="video<?=$videoArchivo->id;?>" class="video-js vjs-default-skin"
                                  controls preload="auto" width="640" height="264">
                                    <!--<source src="<?=$videoArchivo->getUrl();?>" type='<?=$videoArchivo->type;?>'/>-->
                                    <source src="<?=$videoArchivo->getUrl();?>" type='video/mp4'/>
                                </video>
                            </center>
                            <hr>
                            <!-- Estado -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    Estado
                                </label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="va_estadoId<?=$videoArchivo->id;?>">
                                        <?php $s = array(); ?>
                                        <?php $s[$videoArchivo->estadoId] = "selected"; ?>
                                        <?php foreach ($videoArchivo->estados as $estadoId=>$estadoString) { ?>
                                            <option value="<?=$estadoId?>" <?=$s[$estadoId]?>>
                                                <?=$estadoString;?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <!-- Comentario -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    Comentario
                                </label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" id="va_comentario<?=$videoArchivo->id;?>"><?=Helper::sanitize($videoArchivo->comentario);?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button data-style="slide-left" class="btn btn-primary ladda-button saveArchivo" data-id="<?=$videoArchivo->id;?>">
                            <span class="ladda-label">
                                Guardar
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } ?>

<script>
    //Save Archivo
    $(document).on('click', 'button.saveArchivo', function (e) {
        var id = $(this).attr("data-id");
        $.ajax({
            type: "POST",
            data: {
                id: id,
                estadoId: $("#va_estadoId"+id).val(),
                comentario: $("#va_comentario"+id).val(),
            },
            url: "<?=Url::site('admin/videos/saveArchivo');?>",
        }).done(function (msg) {
            document.location.href = "<?=Url::site('admin/videos/edit/'.$video->id);?>";
        });
    });
    //Document Ready
    $(function () {
        //File Upload
        $('#fileupload').fileupload({
            maxChunkSize: 10000000,
            url: "<?=Url::site('api/uploadVideo');?>",
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
        })/*.on('fileuploadsubmit', function (e, data) {
           data.formData = data.context.find(':input').serializeArray();
        });*/
    });
</script>
