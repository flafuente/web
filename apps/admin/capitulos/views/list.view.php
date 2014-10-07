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
                <?=HTML::search();?>
            </div>
            <!-- Programa -->
            <div class="col-sm-3">
                <?=HTML::select("programaId", $programas, $_REQUEST["programaId"], array("class" => "select2 change-submit", "style" => "width: 100%;"), array("id" => 0, "display" => "- Programa -"), array("display" => "titulo")); ?>
            </div>
            <!-- Estado -->
            <div class="col-sm-3 col-xs-6 col-md-2 filter">
                <?php $capituloNull = new Capitulo(); ?>
                <?=HTML::select("estadoId", $capituloNull->estados, $_REQUEST["estadoId"], array("class" => "change-submit"), array("id" => "-1", "display" => "- Estado -")); ?>
            </div>
            <!-- HouseNumber -->
            <div class="col-sm-3 col-xs-6 col-md-2 filter">
                <?=HTML::select("hasEntradaId", array(0 => "No", 1 => "Sí"), $_REQUEST["hasEntradaId"], array("class" => "change-submit"), array("id" => "-1", "display" => "- House Number -")); ?>
            </div>
            <!-- CDN Id -->
            <div class="col-sm-3 col-xs-6 col-md-2 filter">
                <?=HTML::select("hasCdnId", array(0 => "No", 1 => "Sí"), $_REQUEST["hasCdnId"], array("class" => "change-submit"), array("id" => "-1", "display" => "- CDN -")); ?>
            </div>
        </div>
        <?php if (count($results)) { ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><?=Html::sortableLink("id", "Id");?></th>
                            <th><?=Html::sortableLink("estadoId", "Estado");?></th>
                            <th><?=Html::sortableLink("programaId", "Programa");?></th>
                            <th><?=Html::sortableLink("titulo", "Título");?></th>
                            <th><?=Html::sortableLink("temporada", "Temporada");?></th>
                            <th><?=Html::sortableLink("episodio", "Episodio");?></th>
                            <th><?=Html::sortableLink("fechaEmision", "Fecha emisión");?></th>
                            <th><?=Html::sortableLink("dateInsert", "Fecha creación");?></th>
                            <th></th>
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
                                <td>
                                    <?=HTML::formLink("btn-xs btn-primary", "pencil", Url::site("admin/capitulos/edit/".$capitulo->id)); ?>
                                    <?=HTML::formLink("btn-xs btn-danger", "remove", Url::site("admin/capitulos/delete/".$capitulo->id), null, null, "¿Deseas eliminar este capítulo?"); ?>
                                </td>
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
