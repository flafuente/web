<?php defined('_EXE') or die('Restricted access'); ?>

<?php
//Toolbar
if ($seccion->id) {
    $subtitle = "Editar sección";
    $title = "Guardar";
} else {
    $subtitle = "Nueva sección";
    $title = "Crear";
}
Toolbar::addTitle("Sección", "glyphicon-th-large", $subtitle);
if ($seccion->id) {
    //Delete button
    Toolbar::addButton(
        array(
            "title" => "Eliminar",
            "app" => "secciones",
            "action" => "delete",
            "class" => "danger",
            "spanClass" => "remove",
            "confirmation" => "¿Deseas realmente eliminar esta sección?",
            "noAjax" => true,
        )
    );
}
//Cancel button
Toolbar::addButton(
    array(
        "title" => "Cancelar",
        "app" => "secciones",
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
        "app" => "secciones",
        "action" => "save",
        "class" => "success",
        "spanClass" => "ok",
    )
);
Toolbar::render();
?>

<form method="post" name="mainForm" id="mainForm" action="<?=Url::site();?>" class="form-horizontal ajax" role="form" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" name="router" id="router" value="admin">
    <input type="hidden" name="app" id="app" value="secciones">
    <input type="hidden" name="action" id="action" value="save">
    <input type="hidden" name="id" value="<?=$seccion->id?>">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Detalles
                </div>
                <div class="panel-body">
                    <!-- Nombre -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Nombre
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="nombre" name="nombre" class="form-control" value="<?=Helper::sanitize($seccion->nombre);?>">
                        </div>
                    </div>
                </div>
                <?php if (count($contactos)) { ?>
                    <!-- Contactos -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Contactos
                        </label>
                        <div class="col-sm-8">
                            <?php $currentContactos = SeccionContacto::getFieldBy("contactoId", "seccionId", $seccion->id); ?>
                            <?=HTML::select("contactos[]", $contactos, $currentContactos, array("class" => "select2", "multiple" => "true"), null, array("display" => "nombre")); ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</form>
