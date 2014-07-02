<?php defined('_EXE') or die('Restricted access'); ?>

<?php
//Toolbar
Toolbar::addTitle("Programas", "glyphicon-film", "Listar");
//Delete button
Toolbar::addButton(
    array(
        "title" => "Nuevo",
        "app" => "programas",
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
        <input type="hidden" name="app" id="app" value="programas">
        <input type="hidden" name="action" id="action" value="">
        <!-- Filters -->
        <div class="row filters">
            <!-- Search -->
            <div class="col-sm-3 col-xs-6 filter">
                <?=HTML::search();?>
            </div>
            <?php if (count($categorias)) { ?>
                <!-- Categoría -->
                <div class="col-sm-3 col-xs-6 col-md-2 filter">
                    <?=HTML::select("categoriaId", $categorias, $_REQUEST["categoriaId"], array("class" => "change-submit"), array("display" => "- Categoría -"), array("display" => "nombre")); ?>
                </div>
            <?php } ?>
            <!-- Estado -->
            <div class="col-sm-3 col-xs-6 col-md-2 filter">
                <?php $programaNull = new Programa(); ?>
                <?=HTML::select("estadoId", $programaNull->estados, $_REQUEST["estadoId"], array("class" => "change-submit"), array("id" => "-1", "display" => "- Estado -")); ?>
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
                            <th><?=Helper::sortableLink("dateInsert", "Fecha creación");?></th>
                            <th><?=Helper::sortableLink("dateUpdate", "Fecha actualización");?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $programa) { ?>
                            <?php $categoria = new Categoria($programa->categoriaId); ?>
                            <tr>
                                <td><?=$programa->id;?></td>
                                <td>
                                    <span class="label label-<?=$programa->getEstadoCssString();?>">
                                        <?=$programa->getEstadoString();?>
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
                                    <a href="<?=Url::site("admin/programas/edit/".$programa->id);?>">
                                        <?=Helper::sanitize($programa->titulo);?>
                                    </a>
                                </td>
                                <td><?=Helper::humanDate($programa->dateInsert);?></td>
                                <td><?=Helper::humanDate($programa->dateUpdate);?></td>
                                <td>
                                    <?=HTML::formLink("btn-xs btn-primary", "pencil", Url::site("admin/programas/edit/".$programa->id)); ?>
                                    <?=HTML::formLink("btn-xs btn-danger", "remove", Url::site("admin/programas/delete/".$programa->id), null, null, "¿Deseas eliminar este programa?"); ?>
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
                <p>No se han encontrado programas</p>
            </blockquote>
        <?php } ?>
    </form>
</div>
