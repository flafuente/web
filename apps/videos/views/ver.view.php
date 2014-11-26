<?php defined('_EXE') or die('Restricted access'); ?>

<form method="post" name="mainForm" id="mainForm" action="<?=Url::site();?>" class="form-horizontal ajax" role="form" autocomplete="off">
    <input type="hidden" name="app" id="app" value="videos">
    <input type="hidden" name="action" id="action" value="save">
    <input type="hidden" name="id" id="id" value="<?=$video->id;?>">

    <fieldset>
        <legend>
            <?=Helper::sanitize($video->titulo);?>
        </legend>
        <div class="form-group">
            <label class="col-sm-2 control-label">
                Estado
            </label>
            <div class="col-sm-8">
                <p class="form-control-static">
                    <span class="label label-<?=$video->getEstadoCssString();?>">
                        <?=$video->getEstadoString();?>
                    </span>
                </p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">
                Categoría
            </label>
            <div class="col-sm-8">
                <p class="form-control-static">
                    <?php $categoria = new Categoria($video->categoriaId); ?>
                    <?=Helper::sanitize($categoria->nombre); ?>
                </p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">
                Descripción
            </label>
            <div class="col-sm-8">
                <p class="form-control-static">
                    <?=Helper::sanitize($video->descripcion); ?>
                </p>
            </div>
        </div>
        <!-- Texto -->
        <div class="form-group">
            <label class="col-sm-2 control-label">
                Texto embled
            </label>
            <div class="col-sm-8">
                <p class="form-control-static">
                    <?=Helper::sanitize($video->texto);?>
                </p>
            </div>
        </div>
    </fieldset>

    <fieldset>
        <legend>
            Enviar nuevo archivo de vídeo
        </legend>
        <!-- Archivo -->
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
            <div class="col-sm-offset-2 col-sm-8">
                <?=HTML::formButton("btn-success", "ok", "Guardar", array(
                        "data-app" => "videos",
                        "data-action" => "save"
                    )
                );?>
            </div>
        </div>
    </fieldset>

    <fieldset>
        <legend>
            Archivos
        </legend>
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
        <?php } ?>
    </fieldset>

</form>

<?=$controller->view("js.fileupload"); ?>

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
                                    <p class="form-control-static">
                                        <?=$videoArchivo->getEstadoString(); ?>
                                    </p>
                                </div>
                            </div>
                            <!-- Comentario -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    Comentario
                                </label>
                                <div class="col-sm-8">
                                    <p class="form-control-static">
                                        <?=Helper::sanitize($videoArchivo->comentario);?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } ?>
