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
                    <!-- Visible -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Visible
                        </label>
                        <div class="col-sm-8">
                            <input type="hidden" name="visible" value="0">
                            <input type="checkbox" class="switch" name="visible" id="visible" value="1" <?php if($categoria->visible) echo "checked";?>>
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
                                @array_push($categorias, $last);
                                //Select
                                echo HTML::select("order", $categorias, $categoria->order, null,
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
                            <input type="text" id="hashtag" name="hashtag" class="form-control" value="<?=Helper::sanitize($categoria->hashtag);?>" placeholder="#">
                        </div>
                    </div>
                    <!-- Wistia Project Id -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Wistia project hash
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="wistiaHash" name="wistiaHash" class="form-control" value="<?=Helper::sanitize($categoria->wistiaHash);?>">
                        </div>
                    </div>
                    <?php if (count($contactos)) { ?>
                        <!-- Contactos -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                Contactos
                            </label>
                            <div class="col-sm-8">
                                <?php $contactosIds = ContactoCategoria::getFieldBy("contactoId", "categoriaId", $categoria->id); ?>
                                <?=HTML::select("contactos[]", $contactos, $contactosIds, array("class" => "select2", "multiple" => true), null, array("display" => "nombre")); ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</form>
