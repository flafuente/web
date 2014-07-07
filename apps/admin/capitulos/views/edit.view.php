<?php defined('_EXE') or die('Restricted access'); ?>

<?php
//Toolbar
if ($capitulo->id) {
    $subtitle = "Editar capítulo";
    $title = "Guardar";
} else {
    $subtitle = "Nuevo capítulo";
    $title = "Crear";
}
Toolbar::addTitle("Capítulos", "glyphicon-th-list", $subtitle);
if ($capitulo->id) {
    //Delete button
    Toolbar::addButton(
        array(
            "title" => "Eliminar",
            "app" => "capitulos",
            "action" => "delete",
            "class" => "danger",
            "spanClass" => "remove",
            "confirmation" => "¿Deseas realmente eliminar este capítulo?",
        )
    );
}
//Cancel button
Toolbar::addButton(
    array(
        "title" => "Cancelar",
        "app" => "capitulos",
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
        "app" => "capitulos",
        "action" => "save",
        "class" => "success",
        "spanClass" => "ok",
    )
);
Toolbar::render();
?>

<form method="post" name="mainForm" id="mainForm" action="<?=Url::site();?>" class="form-horizontal ajax" role="form" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" name="router" id="router" value="admin">
    <input type="hidden" name="app" id="app" value="capitulos">
    <input type="hidden" name="action" id="action" value="save">
    <input type="hidden" name="id" value="<?=$capitulo->id?>">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <!-- Detalles -->
                <div class="panel-heading">
                    Detalles
                </div>
                <div class="panel-body">
                    <!-- Usuario -->
                    <?php if ($capitulo->userId) { ?>
                        <?php $user = new User($capitulo->userId); ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                Usuario
                            </label>
                            <div class="col-sm-8">
                                <p class="form-control-static">
                                    <a href="<?=Url::site("admin/users/edit/".$user->id);?>">
                                        <?=Helper::sanitize($user->getFullName());?>
                                    </a>
                                </p>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- Estado -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Estado
                        </label>
                        <div class="col-sm-8">
                            <input type="hidden" name="estadoId" value="0">
                            <input type="checkbox" class="switch" name="estadoId" id="estadoId" value="1" <?php if($capitulo->estadoId) echo "checked";?>>
                        </div>
                    </div>
                    <?php if (count($programas)) { ?>
                        <!-- Programa -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                Programa
                            </label>
                            <div class="col-sm-8">
                                <?=HTML::select("programaId", $programas, $capitulo->programaId, null, null, array("display" => "titulo")); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (count($videos)) { ?>
                        <!-- Vídeo -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                Vídeo
                            </label>
                            <div class="col-sm-8">
                                <?=HTML::select("videoId", $videos, $capitulo->videoId, null, array("display" => "Ninguno"), array("display" => "titulo")); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- Título -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Título
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="titulo" name="titulo" class="form-control" value="<?=Helper::sanitize($capitulo->titulo);?>">
                        </div>
                    </div>
                    <!-- Temporada -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Temporada
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="temporada" name="temporada" class="form-control" value="<?=Helper::sanitize($capitulo->temporada);?>">
                        </div>
                    </div>
                    <!-- Episodio -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Episodio
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="episodio" name="episodio" class="form-control" value="<?=Helper::sanitize($capitulo->episodio);?>">
                        </div>
                    </div>
                    <!-- Descripción -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Descripción
                        </label>
                        <div class="col-sm-8">
                            <textarea id="descripcion" name="descripcion" class="form-control"><?=Helper::sanitize($capitulo->descripcion);?></textarea>
                        </div>
                    </div>
                    <!-- Url -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            URL
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="url" name="url" class="form-control" value="<?=Helper::sanitize($capitulo->url);?>">
                        </div>
                    </div>
                    <!-- Duración -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Duración
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="duracion" name="duracion" placeholder="hh:mm:ss" class="form-control" value="<?=Helper::sanitize($capitulo->duracion);?>">
                        </div>
                    </div>
                    <!-- Fecha de emisión -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Fecha de emisión
                        </label>
                        <div class="col-sm-8">
                            <input type="date" id="fechaEmision" name="fechaEmision" placeholder="YYYY-mm-dd" class="form-control" value="<?=Helper::sanitize($capitulo->fechaEmision);?>">
                        </div>
                    </div>
                    <!-- Thumbnail -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Thumbnail
                        </label>
                        <div class="col-sm-8">
                            <input type="file" class="btn-primary btn" name="thumbnail" accept="image/*">
                            <?php if ($capitulo->thumbnail) { ?>
                                <a href="<?=$capitulo->getThumbnailUrl();?>" class="btn btn-default" target="_blank">
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
