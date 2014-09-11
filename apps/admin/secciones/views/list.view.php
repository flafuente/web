<?php defined('_EXE') or die('Restricted access'); ?>

<?php
//Toolbar
Toolbar::addTitle("Categorías", "glyphicon-star", "Listar");
//Delete button
Toolbar::addButton(
    array(
        "title" => "Nueva",
        "app" => "secciones",
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
        <input type="hidden" name="app" id="app" value="secciones">
        <input type="hidden" name="action" id="action" value="">

        <!-- Filters -->
        <div class="row filters">
            <!-- Search -->
            <div class="col-sm-3 col-xs-6 filter">
                <?=HTML::search();?>
            </div>
        </div>

        <?php if (count($results)) { ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><?=Html::sortableLink("id", "Id");?></th>
                            <th><?=Html::sortableLink("nombre", "Nombre");?></th>
                            <th><?=Html::sortableLink("dateInsert", "Fecha creación");?></th>
                            <th><?=Html::sortableLink("dateUpdate", "Fecha actualización");?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $seccion) { ?>
                            <tr>
                                <td><?=$seccion->id;?></a></td>
                                <td>
                                    <a href="<?=Url::site("admin/secciones/edit/".$seccion->id);?>">
                                        <?=Helper::sanitize($seccion->nombre);?>
                                    </a>
                                </td>
                                <td><?=Helper::humanDate($seccion->dateInsert);?></td>
                                <td><?=Helper::humanDate($seccion->dateUpdate);?></td>
                                <td>
                                    <?=HTML::formLink("btn-xs btn-primary", "pencil", Url::site("admin/secciones/edit/".$seccion->id)); ?>
                                    <?=HTML::formLink("btn-xs btn-danger", "remove", Url::site("admin/secciones/delete/".$seccion->id), null, null, "¿Deseas eliminar esta sección?"); ?>
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
                <p>No se han encontrado secciones</p>
            </blockquote>
        <?php } ?>
    </form>
</div>
