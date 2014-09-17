<?php defined('_EXE') or die('Restricted access'); ?>

<?php
//Toolbar
if ($slide->id) {
    $subtitle = "Editar slide";
    $title = "Guardar";
} else {
    $subtitle = "Nueva slide";
    $title = "Crear";
}
Toolbar::addTitle("Slideshow", "glyphicon-picture", $subtitle);
if ($slide->id) {
    //Delete button
    Toolbar::addButton(
        array(
            "title" => "Eliminar",
            "app" => "slideshow",
            "action" => "delete",
            "class" => "danger",
            "spanClass" => "remove",
            "confirmation" => "¿Deseas realmente eliminar esta slide?",
            "noAjax" => true,
        )
    );
}
//Cancel button
Toolbar::addButton(
    array(
        "title" => "Cancelar",
        "link" => Url::site("admin/slideshow"),
        "class" => "primary",
        "spanClass" => "chevron-left",
    )
);
//Save button
Toolbar::addButton(
    array(
        "title" => $title,
        "app" => "slideshow",
        "action" => "save",
        "class" => "success",
        "spanClass" => "ok",
    )
);
Toolbar::render();
?>

<form method="post" name="mainForm" id="mainForm" action="<?=Url::site();?>" class="form-horizontal ajax" role="form" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" name="router" id="router" value="admin">
    <input type="hidden" name="app" id="app" value="slideshow">
    <input type="hidden" name="action" id="action" value="save">
    <input type="hidden" name="id" value="<?=$slide->id?>">
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
                            <input type="text" id="nombre" name="nombre" class="form-control" value="<?=Helper::sanitize($slide->nombre);?>">
                        </div>
                    </div>
                    <!-- Visible -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Visible
                        </label>
                        <div class="col-sm-8">
                            <input type="hidden" name="visible" value="0">
                            <input type="checkbox" class="switch" name="visible" id="visible" value="1" <?php if($slide->visible) echo "checked";?>>
                        </div>
                    </div>
                    <!-- Orden -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Orden
                        </label>
                        <div class="col-sm-8">
                            <?php
                                //Last
                                $last = new stdClass();
                                $last->order = -2;
                                $last->nombre = "- Última -";
                                @array_push($slides, $last);
                                //Select
                                echo HTML::select("order", $slides, $slide->order, null,
                                    array("id" => "-1", "display" => "- Primera -"),
                                    array("id" => "order", "display" => "nombre")
                                );
                            ?>
                        </div>
                    </div>
                    <!-- Url -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Url
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="url" name="url" class="form-control" value="<?=Helper::sanitize($slide->url);?>">
                        </div>
                    </div>
                    <!-- Imágen -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Imágen
                        </label>
                        <div class="col-sm-8">
                            <input type="file" class="btn-primary btn" name="imagenFile" accept="image/*">
                            <?php if ($slide->imagen) { ?>
                                <a href="<?=$slide->getImagenUrl();?>" class="btn btn-default" target="_blank">
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
