<?php defined('_EXE') or die('Restricted access'); ?>

<?php
//Toolbar
Toolbar::addTitle("Vídeos", "facetime-video", "Listar");
//Delete button
Toolbar::addButton(
    array(
        "title" => "Nuevo",
        "app" => "videos",
        "action" => "edit",
        "class" => "success",
        "spanClass" => "plus",
        "noAjax" => true,
    )
);
Toolbar::render();
?>

<div class="main">
    <form method="post" action="<?=Url::site()?>" id="mainForm" name="mainForm" class="form-inline" role="form">
        <input type="hidden" name="router" id="router" value="admin">
        <input type="hidden" name="app" id="app" value="videos">
        <input type="hidden" name="action" id="action" value="">
        <!-- Filters -->
        <div class="row filters">
            <!-- Search -->
            <div class="col-sm-3 col-xs-6 filter">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" value="<?=Helper::sanitize($_REQUEST["search"]);?>">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">Buscar</button>
                    </span>
                </div>
            </div>
            <?php if (count($categorias)) { ?>
                <!-- Categoría -->
                <div class="col-sm-3 col-xs-6 col-md-2 filter">
                    <select class="form-control change-submit" name="categoriaId">
                        <option value="0">Categoría</option>
                        <?php $s = array();$s[$_REQUEST["estadoId"]] = "selected"; ?>
                        <?php foreach ($categorias as $categoria) { ?>
                            <option value="<?=$categoria->id?>" <?=$s[$categoria->id]?>>
                                <?=Helper::sanitize($categoria->nombre);?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>
            <!-- Estado -->
            <div class="col-sm-3 col-xs-6 col-md-2 filter">
                <select class="form-control change-submit" name="estadoId">
                    <option value="-1">Estado</option>
                    <?php $videoNull = new Video(); ?>
                    <?php $s = array();$s[$_REQUEST["estadoId"]] = "selected"; ?>
                    <?php foreach ($videoNull->estados as $estadoId=>$estadoString) { ?>
                        <option value="<?=$estadoId?>" <?=$s[$estadoId]?>>
                            <?=Helper::sanitize($estadoString);?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <!-- Results -->
        <?php if (count($results)) { ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><?=Helper::sortableLink("id", "Id");?></th>
                            <th><?=Helper::sortableLink("estadoId", "Estado");?></th>
                            <th><?=Helper::sortableLink("categoriaId", "Categoría");?></th>
                            <th><?=Helper::sortableLink("titulo", "Título");?></th>
                            <th><?=Helper::sortableLink("userId", "Usuario");?></th>
                            <th><?=Helper::sortableLink("visitas", "Visitas");?></th>
                            <th><?=Helper::sortableLink("dateInsert", "Fecha creación");?></th>
                            <th><?=Helper::sortableLink("dateUpdate", "Fecha actualización");?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $video) { ?>
                            <?php $user = new User($video->userId); ?>
                            <?php $categoria = new Categoria($video->categoriaId); ?>
                            <tr>
                                <td><?=$video->id;?></a></td>
                                <td>
                                    <span class="label label-<?=$video->getEstadoCssString();?>">
                                        <?=$video->getEstadoString();?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($categoria->id) { ?>
                                        <?=Helper::sanitize($categoria->nombre);?>
                                    <?php } else { ?>
                                        -
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="<?=Url::site("admin/videos/edit/".$video->id);?>">
                                        <?=Helper::sanitize($video->titulo);?>
                                    </a>
                                </td>
                                <td>
                                    <a href="<?=Url::site("admin/users/edit/".$user->id);?>">
                                        <?=Helper::sanitize($user->email);?>
                                    </a>
                                </td>
                                <td><?=$video->visitas;?></td>
                                <td><?=Helper::humanDate($video->dateInsert);?></td>
                                <td><?=Helper::humanDate($video->dateUpdate);?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php $controller->setData("pag", $pag); ?>
                <?=$controller->view("modules.pagination");?>
            </div>
        <?php } else { ?>
            <blockquote>
                <p>No se han encontrado videos</p>
            </blockquote>
        <?php } ?>
    </form>
</div>
