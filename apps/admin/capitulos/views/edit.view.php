<?php defined('_EXE') or die('Restricted access'); ?>

<?php
//Toolbar
if ($capitulo->id) {
    $subtitle = "Editar capítulo";
    $title = "Guardar";
} else {
    $subtitle = "Nuevo capítulo";
    $title = "Crear";
}
Toolbar::addTitle("Capítulos", "glyphicon-th-list", $subtitle);
if ($capitulo->id) {
    //Delete button
    Toolbar::addButton(
        array(
            "title" => "Eliminar",
            "app" => "capitulos",
            "action" => "delete",
            "class" => "danger",
            "spanClass" => "remove",
            "confirmation" => "¿Deseas realmente eliminar este capítulo?",
            "noAjax" => true,
        )
    );
}
//Cancel button
Toolbar::addButton(
    array(
        "title" => "Cancelar",
        "link" => Url::site("admin/capitulos"),
        "class" => "primary",
        "spanClass" => "chevron-left",
    )
);
//Save button
Toolbar::addButton(
    array(
        "title" => $title,
        "app" => "capitulos",
        "action" => "save",
        "class" => "success",
        "spanClass" => "ok",
    )
);
Toolbar::render();
?>

<form method="post" name="mainForm" id="mainForm" action="<?=Url::site();?>" class="form-horizontal ajax" role="form" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" name="router" id="router" value="admin">
    <input type="hidden" name="app" id="app" value="capitulos">
    <input type="hidden" name="action" id="action" value="save">
    <input type="hidden" name="id" value="<?=$capitulo->id?>">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <!-- Detalles -->
                <div class="panel-heading">
                    Detalles
                </div>
                <div class="panel-body">
                    <!-- Usuario -->
                    <?php if ($capitulo->userId) { ?>
                        <?php $user = new User($capitulo->userId); ?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">
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
                        <label class="col-sm-3 control-label">
                            Estado
                        </label>
                        <div class="col-sm-8">
                            <input type="hidden" name="estadoId" value="0">
                            <input type="checkbox" class="switch" name="estadoId" id="estadoId" value="1" <?php if($capitulo->estadoId) echo "checked";?>>
                        </div>
                    </div>
                    <?php if (count($programas)) { ?>
                        <!-- Programa -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                Programa
                            </label>
                            <div class="col-sm-8">
                                <?=HTML::select("programaId", $programas, $capitulo->programaId, null, null, array("display" => "titulo")); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- Entrada -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            Entrada
                        </label>
                        <div class="col-sm-8">
                            <input type="text" name="entradaId" id="entradaId" value="<?=$capitulo->entradaId;?>" data-option="<?=$capitulo->getHouseNumber();?>">
                        </div>
                    </div>
                    <!-- CDN Id -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            CDN Id
                        </label>
                        <div class="col-sm-6">
                            <input type="text" id="cdnId" name="cdnId" class="form-control" value="<?=Helper::sanitize($capitulo->cdnId);?>">
                        </div>
                        <?php if ($project->medias) { ?>
                            <input type="hidden" name="wistiaList" id="wistiaListUsed" value="0">
                            <div class="col-sm-3">
                                <button type="button" class="btn btn-primary" id="wistiaList">
                                    Listar
                                </button>
                            </div>
                        <?php } ?>
                    </div>
                    <!-- Título -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            Título
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="titulo" name="titulo" class="form-control" value="<?=Helper::sanitize($capitulo->titulo);?>">
                        </div>
                    </div>
                    <!-- Temporada -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            Temporada
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="temporada" name="temporada" class="form-control" value="<?=Helper::sanitize($capitulo->temporada);?>">
                        </div>
                    </div>
                    <!-- Episodio -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            Episodio
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="episodio" name="episodio" class="form-control" value="<?=Helper::sanitize($capitulo->episodio);?>">
                        </div>
                    </div>
                    <!-- Descripción -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            Descripción
                        </label>
                        <div class="col-sm-8">
                            <textarea id="descripcion" name="descripcion" class="form-control"><?=Helper::sanitize($capitulo->descripcion);?></textarea>
                        </div>
                    </div>
                    <!-- Duración -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            Duración
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="duracion" name="duracion" placeholder="hh:mm:ss" class="form-control" value="<?=Helper::sanitize($capitulo->duracion);?>">
                        </div>
                    </div>
                    <!-- Fecha de emisión -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            Fecha de emisión
                        </label>
                        <div class="col-sm-8">
                            <input type="date" id="fechaEmision" name="fechaEmision" placeholder="YYYY-mm-dd" class="form-control" value="<?=Helper::sanitize($capitulo->fechaEmision);?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <!-- Thumbnail -->
                <div class="panel-heading">
                    Thumbnail
                </div>
                <div class="panel-body">
                    <!-- Thumbnail -->
                    <div class="form-group">
                        <div class="col-sm-12">
                            <img src="<?=$capitulo->getThumbnailUrl();?>" id="thumbnailUrl" width="100%">
                        </div>
                    </div>
                    <?php if ($capitulo->cdnThumbnail && $capitulo->duracion) { ?>
                        <?php $a = explode(":", $capitulo->duracion); ?>
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
                                <input type="text" id="cdnThumbnail" name="cdnThumbnail" class="form-control" value="<?=Helper::sanitize($capitulo->cdnThumbnail);?>">
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="file" class="btn-primary btn" name="thumbnail_capitulo" accept="image/*">
                            <?php if ($capitulo->thumbnail) { ?>
                                <a href="<?=$capitulo->getThumbnailUrl();?>" class="btn btn-default" target="_blank">
                                    <span class="glyphicon glyphicon-eye-open"></span>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Wistia List Modal -->
<?php if ($project->medias) { ?>
    <div class="modal fade" id="wistiaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                    <h4 class="modal-title" id="myModalLabel">Cargar desde Wistia</h4>
                </div>
                <div class="modal-body">
                    <form role="form">
                        <div class="form-group">
                            <select class="form-control" id="wistiaSelect">
                                <?php foreach ($project->medias as $media) { ?>
                                    <option value="<?=$media->hashed_id;?>">
                                        <?=$media->name;?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" id="wistiaLoad" class="btn btn-primary">Cargar</button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script>
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

    //Wistia modal
    $(document).on('click', '#wistiaList', function (e) {
        $('#wistiaModal').modal('show');
    });
    $(document).on('click', '#wistiaLoad', function (e) {
        $('#wistiaModal').modal('hide');
        $('#cdnId').val($('#wistiaSelect').val());
        $("#wistiaListUsed").val(1);
    });

    <?php $config = Registry::getConfig(); ?>
    $(document).ready(function () {
        //Select2 Entradas
        $("#entradaId").select2({
            placeholder: "Buscar entrada",
            minimumInputLength: 1,
            width: '100%',
            ajax: {
                url: "<?=$config->get('parrillasUrl').'/external/entradas';?>",
                dataType: 'json',
                data: function (term) {
                    return {
                        q: term,
                    };
                },
                results: function (data) {
                    return {
                        results: $.map(data.data.entradas, function (item) {
                            return {
                                id: item.id,
                                text: item.nombre + " (" + item.houseNumber + ")"
                            }
                        })
                    };
                }
            },
            <?php if ($capitulo->entradaId) { ?>
                initSelection: function (item, callback) {
                    var id = item.val();
                    var text = item.data('option');
                    var data = { id: id, text: text };
                    callback(data);
                }
            <?php } ?>
        });
    });
</script>
