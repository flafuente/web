<?php defined('_EXE') or die('Restricted access'); ?>

<?php $currentUser = Registry::getUser();?>

<div class="col-md-12 serie_info">
    <div class="well">
        <fieldset>
            <form method="post" name="mainForm" id="mainForm" action="<?=Url::site();?>" class="form-horizontal ajax" role="form">
                <input type="hidden" name="app" id="app" value="">
                <input type="hidden" name="action" id="action" value="">
                <!-- Categoría -->
                <?php if (count($categorias)) { ?>
                    <div class="form-group">
                        <label for="categoriaId" class="col-sm-offset-1 col-sm-3 control-label l-left">
                            Categoría
                        </label>
                        <div class="col-sm-8">
                            <select class="form-control" name="categoriaId" id="categoriaId">
                                <?php foreach ($categorias as $categoria) { ?>
                                    <option value="<?=$categoria->id?>">
                                        <?=$categoria->nombre;?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                <?php } ?>
                <!-- Título -->
                <div class="form-group">
                    <label for="titulo" class="col-sm-offset-1 col-sm-3 control-label l-left">
                        Titulo
                    </label>
                    <div class="col-sm-8">
                        <input type="text" id="titulo" name="titulo" class="form-control">
                    </div>
                </div>
                <!-- Descripción -->
                <div class="form-group">
                    <label for="titulo" class="col-sm-offset-1 col-sm-3 control-label l-left">
                        Descripción
                    </label>
                    <div class="col-sm-8">
                        <textarea name="descripcion" class="form-control" id="descripcion"></textarea>
                    </div>
                </div>
                <!-- Texto -->
                <div class="form-group">
                    <label for="titulo" class="col-sm-offset-1 col-sm-3 control-label l-left">
                        Texto embled
                    </label>
                    <div class="col-sm-8">
                        <textarea id="texto" name="texto" class="form-control"></textarea>
                    </div>
                </div>
                <?php if (count($tags)) { ?>
                    <!-- Tags -->
                    <div class="form-group">
                        <label for="titulo" class="col-sm-offset-1 col-sm-3 control-label l-left">
                            Tags
                        </label>
                        <div class="col-sm-8">
                            <select class="form-control select2" multiple="true" name="tags[]" id="tags">
                                <?php foreach ($tags as $tags) { ?>
                                    <option value="<?=$tags->id?>">
                                        <?=$tags->nombre;?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                <?php } ?>
                <!-- Archivo -->
                <div class="form-group">
                    <label for="titulo" class="col-sm-offset-1 col-sm-3 control-label l-left">
                        Archivo
                    </label>
                    <div class="col-sm-8">
                        <input type="hidden" name="file" id="filename" value="">
                        <input id="fileupload" type="file" class="btn-primary btn" name="files[]" accept="video/*">
                        <br>
                        <br>
                        <!-- The global progress bar -->
                        <div id="progress" class="progress">
                            <div class="progress-bar progress-bar-success"></div>
                        </div>
                        <!-- The container for the uploaded files -->
                        <div id="files" class="files"></div>
                    </div>
                </div>
                <!-- Buttons -->
                <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-2 l-left">
                        <?=HTML::formButton("btn-tribo-grey", "ok", "Guardar", array(
                                "data-app" => "videos",
                                "data-action" => "save"
                            )
                        );?>
                    </div>
                </div>
            </form>
        </fieldset>
    </div>
</div>

<?=$controller->view("js.fileupload"); ?>

<script>
    $("#submit").on( "click", function () {
        $("#app").val("videos");
        $("#action").val("save");
        $("#mainForm").submit();

        return false;
    });
</script>
