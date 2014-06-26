<?php defined('_EXE') or die('Restricted access'); ?>

<?php
//Toolbar
if ($programa->id) {
    $subtitle = "Editar programa";
    $title = "Guardar";
} else {
    $subtitle = "Nuevo programa";
    $title = "Crear";
}
Toolbar::addTitle("Programas", "glyphicon-film", $subtitle);
if ($programa->id) {
    //Delete button
    Toolbar::addButton(
        array(
            "title" => "Eliminar",
            "app" => "programas",
            "action" => "delete",
            "class" => "danger",
            "spanClass" => "remove",
            "confirmation" => "¿Deseas realmente eliminar este programa?",
        )
    );
}
//Cancel button
Toolbar::addButton(
    array(
        "title" => "Cancelar",
        "app" => "programas",
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
        "app" => "programas",
        "action" => "save",
        "class" => "success",
        "spanClass" => "ok",
    )
);
Toolbar::render();
?>

<form method="post" name="mainForm" id="mainForm" action="<?=Url::site();?>" class="form-horizontal ajax" role="form" autocomplete="off">
    <input type="hidden" name="router" id="router" value="admin">
    <input type="hidden" name="app" id="app" value="programas">
    <input type="hidden" name="action" id="action" value="save">
    <input type="hidden" name="id" value="<?=$programa->id?>">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <!-- Detalles -->
                <div class="panel-heading">
                    Detalles
                </div>
                <div class="panel-body">
                    <!-- Usuario -->
                    <?php if ($programa->userId) { ?>
                        <?php $user = new User($programa->userId); ?>
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
                            <input type="checkbox" class="switch" name="estadoId" id="estadoId" value="1" <?php if($programa->estadoId) echo "checked";?>>
                        </div>
                    </div>
                    <?php if (count($categorias)) { ?>
                        <!-- Categoría -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                Categoría
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control" name="categoriaId" id="categoriaId">
                                    <?php $s = array(); ?>
                                    <?php $s[$programa->categoriaId] = "selected"; ?>
                                    <?php foreach ($categorias as $categoria) { ?>
                                        <option value="<?=$categoria->id?>" <?=$s[$categoria->id]?>>
                                            <?=Helper::sanitize($categoria->nombre);?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- Título -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Título
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="titulo" name="titulo" class="form-control" value="<?=Helper::sanitize($programa->titulo);?>">
                        </div>
                    </div>
                    <!-- Subtítulo -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Subtítulo
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="subtitulo" name="subtitulo" class="form-control" value="<?=Helper::sanitize($programa->subtitulo);?>">
                        </div>
                    </div>
                    <!-- Descripción -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Descripción
                        </label>
                        <div class="col-sm-8">
                            <textarea id="descripcion" name="descripcion" class="form-control"><?=Helper::sanitize($programa->descripcion);?></textarea>
                        </div>
                    </div>
                    <!-- Banner -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Banner
                        </label>
                        <div class="col-sm-8">
                            <div id="banner-preview" class="preview" style="display:none">
                                <img src="">
                                <button type="button" class="btn btn-small btn-danger" data-url="">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </button>
                            </div>
                            <div class="upload-div">
                                <input type="hidden" id="banner" name="banner" value="">
                                <span class="btn btn-success fileinput-button">
                                    <i class="glyphicon glyphicon-plus"></i>
                                    <span>Examinar...</span>
                                    <!-- The file input field used as target for the file upload widget -->
                                    <input type="file" class="fileupload" accept="image/*"
                                    data-target="banner" data-width="510" data-height="150"
                                    data-progres="banner-progress" data-preview="banner-preview">
                                </span>
                                <br>
                                <br>
                                <!-- The global progress bar -->
                                <div id="banner-progress" class="progress">
                                    <div class="progress-bar progress-bar-success"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    //Document Ready
    $(function () {
        //File Upload
        $('.fileupload').fileupload({
            url: "<?=Url::site('api/uploadImage');?>",
            formData: "",
            dataType: 'json',
            imageCrop: true,
            imageMaxHeight: $(this).attr("data-height"),
            imageMaxWidth: $(this).attr("data-width"),
            imageForceResize: true,
            done: function (e, data) {
                var element = $(this);
                $.each(data.result.files, function (index, file) {
                    if (!file.error) {
                        $('#' + element.attr('data-target')).val(file.name);
                        $('#' + element.attr('data-preview') + ' img').attr('src', file.thumbnailUrl);
                        $('#' + element.attr('data-preview') + 'button').attr('data-url', file.deleteUrl);
                        $('#' + element.attr('data-preview')).show();
                        element.closest('div.upload-div').hide();
                    } else {
                        $('#' + element.attr('data-target')).val("");
                        alert(file.error);
                    }
                });
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#' + $(this).attr('data-progres') + ' .progress-bar').css(
                    'width',
                    progress + '%'
                );
            },
            /*destroy: function (e, data) {
                var element = $(this);
                $('#' + element.attr('data-preview')).hide();
                $('#' + element.attr('data-target')).val("");
                element.closest('div.upload-div').show();
            }*/
        })
    });
    //Eliminar
    $(document).on('click', '.preview button', function (e) {
        element = $(this);
        $.get(element.attr('data-url'), function (data) {
            element.closest('div.preview').hide();
            element.closest('div.preview').parent().find('div.upload-div').show();
        });

        return false;
    });
</script>
