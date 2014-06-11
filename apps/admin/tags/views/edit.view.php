<?php defined('_EXE') or die('Restricted access'); ?>

<?php
if ($tag->id) {
    $toolBar['subtitle'] = "Editar tag";
    $title = "Guardar";
} else {
    $toolBar['subtitle'] = "Nuevo tag";
    $title = "Crear";
}
$toolBar['title'] = "Tags";
$toolBar['class'] = "bookmark";
$toolBar['buttons'][] = array(
    "buttonClass" => "success",
    "spanClass" => "ok",
    "title" => $title,
    "app" => "tags",
    "action" => "save",
);
$toolBar['buttons'][] = array(
    "buttonClass" => "primary",
    "spanClass" => "chevron-left",
    "title" => "Cancelar",
    "app" => "tags",
    "action" => "index",
    "noAjax" => true,
);
if ($tag->id) {
    $toolBar['buttons'][] = array(
        "buttonClass" => "danger",
        "spanClass" => "remove",
        "title" => "Eliminar",
        "app" => "tags",
        "action" => "delete",
        "confirmation" => "¿Deseas realmente eliminar este tag?",
    );
}
$controller->setData("toolBar", $toolBar);
echo $controller->view("modules.toolbar");
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
