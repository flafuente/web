<?php defined('_EXE') or die('Restricted access'); ?>

<?php
//Toolbar
Toolbar::addTitle("Capítulos", "glyphicon-th-list", "Listar");
//Delete button
Toolbar::addButton(
    array(
        "title" => "Nuevo",
        "app" => "capitulos",
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
        <input type="hidden" name="app" id="app" value="capitulos">
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
        </div>
        <?php if (count($results)) { ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><?=Helper::sortableLink("id", "Id");?></th>
                            <th><?=Helper::sortableLink("estadoId", "Estado");?></th>
                            <th><?=Helper::sortableLink("programaId", "Programa");?></th>
                            <th><?=Helper::sortableLink("titulo", "Título");?></th>
                            <th><?=Helper::sortableLink("temporada", "Temporada");?></th>
                            <th><?=Helper::sortableLink("episodio", "Episodio");?></th>
                            <th><?=Helper::sortableLink("fechaEmision", "Fecha emisión");?></th>
                            <th><?=Helper::sortableLink("dateInsert", "Fecha creación");?></th>
                            <th><?=Helper::sortableLink("dateUpdate", "Fecha actualización");?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $capitulo) { ?>
                            <?php $programa = new Programa($capitulo->programaId); ?>
                            <tr>
                                <td><?=$capitulo->id;?></td>
                                <td>
                                    <span class="label label-<?=$capitulo->getEstadoCssString();?>">
                                        <?=$capitulo->getEstadoString();?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($programa->id) { ?>
                                        <?=Helper::sanitize($programa->titulo);?>
                                    <?php } else { ?>
                                        -
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="<?=Url::site("admin/capitulos/edit/".$capitulo->id);?>">
                                        <?=Helper::sanitize($capitulo->titulo);?>
                                    </a>
                                </td>
                                <td><?=$capitulo->temporada;?></td>
                                <td><?=$capitulo->episodio;?></td>
                                <td><?=Helper::humanDate($capitulo->fechaEmision);?></td>
                                <td><?=Helper::humanDate($capitulo->dateInsert);?></td>
                                <td><?=Helper::humanDate($capitulo->dateUpdate);?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php $controller->setData("pag", $pag); ?>
                <?=$controller->view("modules.pagination");?>
            </div>
        <?php } else { ?>
            <blockquote>
                <p>No se han encontrado capítulos</p>
            </blockquote>
        <?php } ?>
    </form>
</div>
