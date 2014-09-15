<?php defined('_EXE') or die('Restricted access'); ?>

<?php
//Toolbar
if ($contacto->id) {
    $subtitle = "Editar contacto";
    $title = "Guardar";
} else {
    $subtitle = "Nuevo contacto";
    $title = "Crear";
}
Toolbar::addTitle("Contactos", "glyphicon-envelope", $subtitle);
if ($contacto->id) {
    //Delete button
    Toolbar::addButton(
        array(
            "title" => "Eliminar",
            "app" => "contactos",
            "action" => "delete",
            "class" => "danger",
            "spanClass" => "remove",
            "confirmation" => "¿Deseas realmente eliminar este contacto?",
            "noAjax" => true,
        )
    );
}
//Cancel button
Toolbar::addButton(
    array(
        "title" => "Cancelar",
        "link" => Url::site("admin/contactos"),
        "class" => "primary",
        "spanClass" => "chevron-left",
    )
);
//Save button
Toolbar::addButton(
    array(
        "title" => $title,
        "app" => "contactos",
        "action" => "save",
        "class" => "success",
        "spanClass" => "ok",
    )
);
Toolbar::render();
?>

<form method="post" name="mainForm" id="mainForm" action="<?=Url::site();?>" class="form-horizontal ajax" role="form" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" name="router" id="router" value="admin">
    <input type="hidden" name="app" id="app" value="contactos">
    <input type="hidden" name="action" id="action" value="save">
    <input type="hidden" name="id" value="<?=$contacto->id?>">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Detalles
                </div>
                <div class="panel-body">
                    <!-- Visible -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Visible
                        </label>
                        <div class="col-sm-8">
                            <input type="hidden" name="visible" value="0">
                            <input type="checkbox" class="switch" name="visible" id="visible" value="1" <?php if($user->visible) echo "checked";?>>
                        </div>
                    </div>
                    <!-- Nombre -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Nombre
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="nombre" name="nombre" class="form-control" value="<?=Helper::sanitize($contacto->nombre);?>">
                        </div>
                    </div>
                    <!-- Email -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Email
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="email" name="email" class="form-control" value="<?=Helper::sanitize($contacto->email);?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
