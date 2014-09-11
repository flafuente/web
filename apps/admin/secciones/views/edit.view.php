<?php defined('_EXE') or die('Restricted access'); ?>

<?php
//Toolbar
if ($categoria->id) {
    $subtitle = "Editar categoría";
    $title = "Guardar";
} else {
    $subtitle = "Nueva categoría";
    $title = "Crear";
}
Toolbar::addTitle("Categorías", "glyphicon-star", $subtitle);
if ($categoria->id) {
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
        "link" => Url::site("admin/secciones"),
        "class" => "primary",
        "spanClass" => "chevron-left",
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
                    <!-- Visible -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Visible
                        </label>
                        <div class="col-sm-8">
                            <input type="hidden" name="visible" value="0">
                            <input type="checkbox" class="switch" name="visible" id="visible" value="1" <?php if($seccion->visible) echo "checked";?>>
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
                                $last->id = "-2";
                                $last->nombre = "- Último -";
                                @array_push($secciones, $last);
                                //Select
                                echo HTML::select("order", $secciones, $seccion->order, null,
                                    array("id" => "-1", "display" => "- Primero -"),
                                    array("id" => "order", "display" => "nombre")
                                );
                            ?>
                        </div>
                    </div>
                    <!-- Hashtag -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Hashtag
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="hashtag" name="hashtag" class="form-control" value="<?=Helper::sanitize($seccion->hashtag);?>" placeholder="#">
                        </div>
                    </div>
                    <!-- Color -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Color
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="color" name="color" class="form-control color-picker" value="<?=Helper::sanitize($seccion->color);?>">
                        </div>
                    </div>
                    <!-- Thumbnail -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Thumbnail
                        </label>
                        <div class="col-sm-8">
                            <input type="file" class="btn-primary btn" name="thumbnail" accept="image/*">
                            <?php if ($seccion->thumbnail) { ?>
                                <a href="<?=$seccion->getThumbnailUrl();?>" class="btn btn-default" target="_blank">
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
