<?php defined('_EXE') or die('Restricted access'); ?>

<?php
//Toolbar
if ($programa->id) {
    $subtitle = "Editar programa";
    $title = "Guardar";
} else {
    $subtitle = "Nuevo programa";
    $title = "Crear";
}
Toolbar::addTitle("Programas", "glyphicon-film", $subtitle);
if ($programa->id) {
    //Delete button
    Toolbar::addButton(
        array(
            "title" => "Eliminar",
            "app" => "programas",
            "action" => "delete",
            "class" => "danger",
            "spanClass" => "remove",
            "confirmation" => "¿Deseas realmente eliminar este programa?",
            "noAjax" => true,
        )
    );
}
//Cancel button
Toolbar::addButton(
    array(
        "title" => "Cancelar",
        "app" => "programas",
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
        "app" => "programas",
        "action" => "save",
        "class" => "success",
        "spanClass" => "ok",
    )
);
Toolbar::render();
?>

<form method="post" name="mainForm" id="mainForm" action="<?=Url::site();?>" class="form-horizontal ajax" role="form" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" name="router" id="router" value="admin">
    <input type="hidden" name="app" id="app" value="programas">
    <input type="hidden" name="action" id="action" value="save">
    <input type="hidden" name="id" value="<?=$programa->id?>">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <!-- Detalles -->
                <div class="panel-heading">
                    Detalles
                </div>
                <div class="panel-body">
                    <!-- Usuario -->
                    <?php if ($programa->userId) { ?>
                        <?php $user = new User($programa->userId); ?>
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
                            <input type="checkbox" class="switch" name="estadoId" id="estadoId" value="1" <?php if($programa->estadoId) echo "checked";?>>
                        </div>
                    </div>
                    <?php if (count($categorias)) { ?>
                        <!-- Categoría -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                Categoría
                            </label>
                            <div class="col-sm-8">
                                <?=HTML::select("categoriaId", $categorias, $programa->categoriaId, null, null, array("display" => "nombre")); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- Destacado -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Destacado
                        </label>
                        <div class="col-sm-8">
                            <input type="hidden" name="destacado" value="0">
                            <input type="checkbox" class="switch" name="destacado" id="destacado" value="1" <?php if($categoria->destacado) echo "checked";?>>
                        </div>
                    </div>
                    <!-- Color -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Color (Parrilla interna)
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="color" name="color" class="form-control color-picker" value="<?=Helper::sanitize($programa->color);?>">
                        </div>
                    </div>
                    <!-- Título -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Título
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="titulo" name="titulo" class="form-control" value="<?=Helper::sanitize($programa->titulo);?>">
                        </div>
                    </div>
                    <!-- Subtítulo -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Subtítulo
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="subtitulo" name="subtitulo" class="form-control" value="<?=Helper::sanitize($programa->subtitulo);?>">
                        </div>
                    </div>
                    <!-- Descripción -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Descripción
                        </label>
                        <div class="col-sm-8">
                            <textarea id="descripcion" name="descripcion" class="form-control"><?=Helper::sanitize($programa->descripcion);?></textarea>
                        </div>
                    </div>
                    <!-- Banner -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Banner
                        </label>
                        <div class="col-sm-8">
                            <input type="file" class="btn-primary btn" name="banner" accept="image/*">
                            <?php if ($programa->banner) { ?>
                                <a href="<?=$programa->getBannerUrl();?>" class="btn btn-default" target="_blank">
                                    <span class="glyphicon glyphicon-eye-open"></span>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                    <!-- Thumbnail -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Thumbnail
                        </label>
                        <div class="col-sm-8">
                            <input type="file" class="btn-primary btn" name="thumbnail" accept="image/*">
                            <?php if ($programa->thumbnail) { ?>
                                <a href="<?=$programa->getThumbnailUrl();?>" class="btn btn-default" target="_blank">
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
