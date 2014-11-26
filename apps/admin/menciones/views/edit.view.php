<?php
defined('_EXE') or die('Restricted access'); ?>

<?php
//Edit / New
if ($mencion->id) {
    $subtitle = "Editar";
    $title = "Guardar";
} else {
    $subtitle = "Nueva";
    $title = "Crear";
}
//Toolbar
Toolbar::addTitle("Menciones", "glyphicon-coment", $subtitle);
if ($mencion->id) {
    //Delete button
    Toolbar::addButton(
        array(
            "title" => "Eliminar",
            "link" => Url::site("admin/menciones/delete/".$nota->id),
            "class" => "danger",
            "spanClass" => "remove",
            "confirmation" => "¿Deseas realmente eliminar esta mención?",
        )
    );
}
//Cancel button
Toolbar::addButton(
    array(
        "title" => "Cancelar",
        "link" => Url::site("admin/menciones"),
        "class" => "primary",
        "spanClass" => "chevron-left",
    )
);
//Save button
Toolbar::addButton(
    array(
        "title" => $title,
        "app" => "menciones",
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
        <input type="hidden" name="app" id="app" value="menciones">
        <input type="hidden" name="action" id="action" value="save">
        <input type="hidden" name="id" value="<?=$mencion->id;?>">
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
                                <input type="checkbox" class="switch" name="estadoId" id="estadoId" value="1" <?php if($mencion->estadoId) echo "checked";?>>
                            </div>
                        </div>

                        <!-- Orden -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                Orden
                            </label>
                            <div class="col-sm-8">
                                <?php
                                    //Last
                                    $last = new stdClass();
                                    $last->order = -2;
                                    $last->titulo = "- Último -";
                                    @array_push($menciones, $last);
                                    //Select
                                    echo HTML::select("order", $menciones, $mencion->order, null,
                                        array("id" => "-1", "display" => "- Primero -"),
                                        array("id" => "order", "display" => "titulo")
                                    );
                                ?>
                            </div>
                        </div>

                        <!-- Titulo -->
                        <div class="form-group">
                            <label for="string" class="col-sm-3 control-label">
                                Titulo
                            </label>
                            <div class="col-sm-8">
                                <input type="text" id="titulo" name="titulo" class="form-control" value="<?=Helper::sanitize($mencion->titulo);?>">
                            </div>
                        </div>

                        <!-- Descripcion -->
                        <div class="form-group">
                            <label for="string" class="col-sm-3 control-label">
                                Descripcion
                            </label>
                            <div class="col-sm-8">
                                <textarea id="descripcion" name="descripcion" class="form-control"><?=Helper::sanitize($mencion->descripcion);?></textarea>
                            </div>
                        </div>

                        <!-- Link -->
                        <div class="form-group">
                            <label for="string" class="col-sm-3 control-label">
                                Link
                            </label>
                            <div class="col-sm-8">
                                <input type="text" id="link" name="link" class="form-control" value="<?=Helper::sanitize($mencion->link);?>">
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
                                <?php if ($mencion->imagen) { ?>
                                    <a href="<?=$mencion->getImagenUrl();?>" class="btn btn-default" target="_blank">
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
                                <?php if ($mencion->archivo) { ?>
                                    <a href="<?=$mencion->getArchivoUrl();?>" class="btn btn-default" target="_blank">
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
