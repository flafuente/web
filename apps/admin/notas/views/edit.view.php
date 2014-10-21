<?php
defined('_EXE') or die('Restricted access'); ?>

<?php
//Edit / New
if ($nota->id) {
    $subtitle = "Editar";
    $title = "Guardar";
} else {
    $subtitle = "Nueva";
    $title = "Crear";
}
//Toolbar
Toolbar::addTitle("Notas de prensa", "glyphicon-bullhorn", $subtitle);
if ($nota->id) {
    //Delete button
    Toolbar::addButton(
        array(
            "title" => "Eliminar",
            "link" => Url::site("admin/notas/delete/".$nota->id),
            "class" => "danger",
            "spanClass" => "remove",
            "confirmation" => "¿Deseas realmente eliminar esta nota?",
        )
    );
}
//Cancel button
Toolbar::addButton(
    array(
        "title" => "Cancelar",
        "link" => Url::site("admin/notas"),
        "class" => "primary",
        "spanClass" => "chevron-left",
    )
);
//Save button
Toolbar::addButton(
    array(
        "title" => $title,
        "app" => "notas",
        "action" => "save",
        "class" => "success",
        "spanClass" => "ok",
    )
);
//Render
Toolbar::render();
?>

<div class="main">
    <form method="post" id="mainForm" action="<?=Url::site();?>" class="form-horizontal ajax" role="form" autocomplete="off" enctype="multipart/form-data">
        <input type="hidden" name="router" id="router" value="admin">
        <input type="hidden" name="app" id="app" value="notas">
        <input type="hidden" name="action" id="action" value="save">
        <input type="hidden" name="id" value="<?=$nota->id;?>">
        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Detalles
                    </div>
                    <div class="panel-body">

                        <!-- Estado -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                Estado
                            </label>
                            <div class="col-sm-8">
                                <input type="hidden" name="estadoId" value="0">
                                <input type="checkbox" class="switch" name="estadoId" id="estadoId" value="1" <?php if($nota->estadoId) echo "checked";?>>
                            </div>
                        </div>

                        <!-- Titulo -->
                        <div class="form-group">
                            <label for="string" class="col-sm-3 control-label">
                                Titulo
                            </label>
                            <div class="col-sm-8">
                                <input type="text" id="titulo" name="titulo" class="form-control" value="<?=Helper::sanitize($nota->titulo);?>">
                            </div>
                        </div>

                        <!-- Descripcion -->
                        <div class="form-group">
                            <label for="string" class="col-sm-3 control-label">
                                Descripcion
                            </label>
                            <div class="col-sm-8">
                                <textarea id="descripcion" name="descripcion" class="form-control"><?=Helper::sanitize($nota->descripcion);?></textarea>
                            </div>
                        </div>

                        <!-- Nota -->
                        <div class="form-group">
                            <label for="string" class="col-sm-3 control-label">
                                Nota
                            </label>
                            <div class="col-sm-8">
                                <textarea id="nota" name="nota" class="form-control"><?=Helper::sanitize($nota->nota);?></textarea>
                            </div>
                        </div>

                        <!-- Fecha -->
                        <div class="form-group">
                            <label for="string" class="col-sm-3 control-label">
                                Fecha
                            </label>
                            <div class="col-sm-8">
                                <input type="text" id="fecha" name="fecha" placeholder="YYYY-mm-dd" class="form-control" value="<?=Helper::sanitize($nota->fecha);?>">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <!-- Archivos -->
                    <div class="panel-heading">
                        Archivos
                    </div>
                    <div class="panel-body">
                        <!-- Imagen -->
                        <div class="form-group">
                            <label for="string" class="col-sm-3 control-label">
                                Imagen
                            </label>
                            <div class="col-sm-8">
                                <input type="file" id="fileImagen" name="fileImagen" class="btn-primary btn"  accept="image/*">
                                <?php if ($nota->imagen) { ?>
                                    <a href="<?=$nota->getImagenUrl();?>" class="btn btn-default" target="_blank">
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- Archivo -->
                        <div class="form-group">
                            <label for="string" class="col-sm-3 control-label">
                                Archivo
                            </label>
                            <div class="col-sm-8">
                                <input type="file" id="fileArchivo" name="fileArchivo" class="btn-primary btn" >
                                <?php if ($nota->archivo) { ?>
                                    <a href="<?=$nota->getArchivoUrl();?>" class="btn btn-default" target="_blank">
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
</div>

<script>
    $(document).ready(function () {
        $('textarea').summernote();
        $('#fecha').datepicker({ dateFormat: 'yy-mm-dd' });
    });
</script>
