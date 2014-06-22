<?php defined('_EXE') or die('Restricted access'); ?>

<?php
//Toolbar
if ($categoria->id) {
    $subtitle = "Editar tag";
    $title = "Guardar";
} else {
    $subtitle = "Nuevo tag";
    $title = "Crear";
}
Toolbar::addTitle("Tags", "glyphicon-asterisk", $subtitle);
if ($categoria->id) {
    //Delete button
    Toolbar::addButton(
        array(
            "title" => "Eliminar",
            "app" => "tags",
            "action" => "delete",
            "class" => "danger",
            "spanClass" => "remove",
            "confirmation" => "¿Deseas realmente eliminar este tag?",
        )
    );
}
//Cancel button
Toolbar::addButton(
    array(
        "title" => "Cancelar",
        "app" => "tags",
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
        "app" => "tags",
        "action" => "save",
        "class" => "success",
        "spanClass" => "ok",
    )
);
Toolbar::render();
?>

<form method="post" name="mainForm" id="mainForm" action="<?=Url::site();?>" class="form-horizontal ajax" role="form" autocomplete="off">
    <input type="hidden" name="router" id="router" value="admin">
    <input type="hidden" name="app" id="app" value="tags">
    <input type="hidden" name="action" id="action" value="save">
    <input type="hidden" name="id" value="<?=$tag->id?>">
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
                            <input type="text" id="nombre" name="nombre" class="form-control" value="<?=Helper::sanitize($tag->nombre);?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
