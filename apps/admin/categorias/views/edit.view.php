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
Toolbar::addTitle("Categorías", "glyphicon-bookmark", $subtitle);
if ($categoria->id) {
    //Delete button
    Toolbar::addButton(
        array(
            "title" => "Eliminar",
            "app" => "categorias",
            "action" => "delete",
            "class" => "danger",
            "spanClass" => "remove",
            "confirmation" => "¿Deseas realmente eliminar esta categoría?",
            "noAjax" => true,
        )
    );
}
//Cancel button
Toolbar::addButton(
    array(
        "title" => "Cancelar",
        "link" => Url::site("admin/categorias"),
        "class" => "primary",
        "spanClass" => "chevron-left",
    )
);
//Save button
Toolbar::addButton(
    array(
        "title" => $title,
        "app" => "categorias",
        "action" => "save",
        "class" => "success",
        "spanClass" => "ok",
    )
);
Toolbar::render();
?>

<form method="post" name="mainForm" id="mainForm" action="<?=Url::site();?>" class="form-horizontal ajax" role="form" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" name="router" id="router" value="admin">
    <input type="hidden" name="app" id="app" value="categorias">
    <input type="hidden" name="action" id="action" value="save">
    <input type="hidden" name="id" value="<?=$categoria->id?>">
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
                            <input type="text" id="nombre" name="nombre" class="form-control" value="<?=Helper::sanitize($categoria->nombre);?>">
                        </div>
                    </div>
                    <!-- Tipo -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Tipo
                        </label>
                        <div class="col-sm-8">
                            <?=HTML::select("tipoId", $categoria->tipos, $categoria->tipoId, array("class" => "select2")); ?>
                        </div>
                    </div>
                    <!-- Destacada -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Destacada
                        </label>
                        <div class="col-sm-8">
                            <input type="hidden" name="destacada" value="0">
                            <input type="checkbox" class="switch" name="destacada" id="destacada" value="1" <?php if($categoria->destacada) echo "checked";?>>
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
                                array_push($categorias, $last);
                                //Select
                                echo HTML::select("order", $categorias, $categoria->order, null,
                                    array("id" => "-1", "display" => "- Primero -"),
                                    array("id" => "order", "display" => "nombre")
                                );
                            ?>
                        </div>
                    </div>
                    <!-- Secciones -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Secciones
                        </label>
                        <div class="col-sm-8">
                            <?php $seccionesIds = $categoria->getSecciones(); ?>
                            <?=HTML::select("secciones[]", $categoria->seccionesTipos, $seccionesIds, array("class" => "select2", "multiple" => "true")); ?>
                        </div>
                    </div>
                    <!-- Hashtag -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Hashtag
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="hashtag" name="hashtag" class="form-control" value="<?=Helper::sanitize($categoria->hashtag);?>" placeholder="#">
                        </div>
                    </div>
                    <!-- Color -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Color
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="color" name="color" class="form-control color-picker" value="<?=Helper::sanitize($categoria->color);?>">
                        </div>
                    </div>
                    <!-- Thumbnail -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Thumbnail
                        </label>
                        <div class="col-sm-8">
                            <input type="file" class="btn-primary btn" name="thumbnail" accept="image/*">
                            <?php if ($categoria->thumbnail) { ?>
                                <a href="<?=$categoria->getThumbnailUrl();?>" class="btn btn-default" target="_blank">
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
