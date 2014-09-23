<?php defined('_EXE') or die('Restricted access'); ?>

<?php
//Toolbar
if ($articulo->id) {
    $subtitle = "Editar artículo";
    $title = "Guardar";
} else {
    $subtitle = "Nuevo artículo";
    $title = "Crear";
}
Toolbar::addTitle("Artículos", "glyphicon-pencil", $subtitle);
if ($articulo->id) {
    /*//Delete button
    Toolbar::addButton(
        array(
            "title" => "Eliminar",
            "app" => "articulos",
            "action" => "delete",
            "class" => "danger",
            "spanClass" => "remove",
            "confirmation" => "¿Deseas realmente eliminar este artículo?",
            "noAjax" => true,
        )
    );*/
}
//Cancel button
Toolbar::addButton(
    array(
        "title" => "Cancelar",
        "link" => Url::site("admin/articulos"),
        "class" => "primary",
        "spanClass" => "chevron-left",
    )
);
//Save button
Toolbar::addButton(
    array(
        "title" => $title,
        "app" => "articulos",
        "action" => "save",
        "class" => "success",
        "spanClass" => "ok",
    )
);
Toolbar::render();
?>

<form method="post" name="mainForm" id="mainForm" action="<?=Url::site();?>" class="form-horizontal ajax" role="form" autocomplete="off">
    <input type="hidden" name="router" id="router" value="admin">
    <input type="hidden" name="app" id="app" value="articulos">
    <input type="hidden" name="action" id="action" value="save">
    <input type="hidden" name="id" value="<?=$articulo->id?>">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Detalles
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Nombre
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="nombre" name="nombre" class="form-control" value="<?=Helper::sanitize($articulo->nombre);?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Texto
                        </label>
                        <div class="col-sm-8">
                            <textarea id="texto" name="texto" class="form-control"><?=Helper::sanitize($articulo->texto);?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        $('#texto').summernote();
    });
</script>
