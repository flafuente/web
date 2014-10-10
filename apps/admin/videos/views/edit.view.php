<?php defined('_EXE') or die('Restricted access'); ?>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=places"></script>

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
            "noAjax" => true,
        )
    );
}
//Cancel button
Toolbar::addButton(
    array(
        "title" => "Cancelar",
        "link" => Url::site("admin/videos"),
        "class" => "primary",
        "spanClass" => "chevron-left",
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
                    <!-- Ubicación -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Ubicación
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="localizacion" name="localizacion" class="form-control" value="<?=Helper::sanitize($video->localizacion);?>">
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
                    <!-- Texto -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Texto embled
                        </label>
                        <div class="col-sm-8">
                            <textarea id="texto" name="texto" class="form-control"><?=Helper::sanitize($video->texto);?></textarea>
                        </div>
                    </div>
                    <?php if (count($tags)) { ?>
                        <!-- Tags -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                Tags
                            </label>
                            <div class="col-sm-8">
                                <?php $currentTags = VideoTag::getFieldBy("tagId", "videoId", $video->id); ?>
                                <?=HTML::select("tags[]", $tags, $currentTags, array("class" => "select2", "multiple" => "true"), null, array("display" => "nombre")); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- CDN Id -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            CDN Id
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="cdnId" name="cdnId" class="form-control" value="<?=Helper::sanitize($video->cdnId);?>">
                        </div>
                    </div>
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
                <?php if ($video->estadoCdnId) { ?>
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                CDN
                                <?php if ($video->estadoCdnId == 1) { ?>
                                    <span class="label label-default">
                                        Subida en curso
                                    </span>
                                <?php } elseif ($video->estadoCdnId == 2) { ?>
                                    <span class="label label-primary">
                                        Conversión en curso
                                    </span>
                                <?php } elseif ($video->estadoConversionId == 4) { ?>
                                    <span class="label label-danger">
                                        Error de conversión
                                    </span>
                                <?php } else { ?>
                                    <span class="label label-success">
                                        Finalizado
                                    </span>
                                <?php } ?>
                            </div>
                            <div class="panel-body">
                                <?php if ($video->estadoCdnId == 3) { ?>
                                    <?=HTML::wistiaPlayer($video->cdnId);?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if (is_array($videosArchivos)) { ?>
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Archivos
                            </div>
                            <div class="panel-body">
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
                                                    <?php if ($videoArchivo->estadoConversionId == 0) { ?>
                                                        <span class="label label-default">
                                                            Pendiente de conversión
                                                        </span>
                                                    <?php } elseif ($videoArchivo->estadoConversionId == 1) { ?>
                                                        <span class="label label-primary">
                                                            Conversión en curso
                                                        </span>
                                                    <?php } elseif ($videoArchivo->estadoConversionId == 3) { ?>
                                                        <span class="label label-danger">
                                                            Error de conversión
                                                        </span>
                                                    <?php } else { ?>
                                                        <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#archivo<?=$videoArchivo->id;?>">
                                                            <span class="glyphicon glyphicon-play"></span>
                                                        </button>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($video->thumbnail && $video->duracion) { ?>
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Wistia Thumbnail
                            </div>
                            <div class="panel-body">
                                <!-- Thumbnail -->
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <img src="<?=$video->getThumbnailUrl();?>" id="thumbnailUrl" width="100%">
                                    </div>
                                </div>
                                <?php if ($video->thumbnail && $video->duracion) { ?>
                                    <?php $a = explode(":", $video->duracion); ?>
                                    <?php $segundos = (+$a[0]) * 60 * 60 + (+$a[1]) * 60 + (+$a[2]); ?>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <input type="range" id="range" min="0" max="<?=$segundos;?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">
                                            Thumbnail CDN
                                        </label>
                                        <div class="col-sm-9">
                                            <input type="text" id="cdnThumbnail" name="cdnThumbnail" class="form-control" value="<?=Helper::sanitize($video->thumbnail);?>">
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
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

<?=$controller->view("js.fileupload", "videos"); ?>

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

    //Wistia thumbnail
    $(document).on('change', '#range', function (e) {
        second = $(this).val();
        url = $("#cdnThumbnail").val();
        if (url) {
            param = "video_still_time=" + second;
            if (url.indexOf("video_still_time") > -1) {
                url = url.replace(/(video_still_time=).*?(&)/,'$1' + param + '$2');
            } else {
                url += "&" + param;
            }
            $("#thumbnailUrl").attr("src", url);
            $("#cdnThumbnail").val(url);
        }
    });
</script>

<!-- Google Autocomplete -->
<script>
    $("#localizacion").placepicker();
</script>
