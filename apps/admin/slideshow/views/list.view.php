<?php defined('_EXE') or die('Restricted access'); ?>

<?php
//Toolbar
Toolbar::addTitle("Slideshow", "glyphicon-picture", "Listar");
//Delete button
Toolbar::addButton(
    array(
        "title" => "Nueva slide",
        "app" => "slideshow",
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
        <input type="hidden" name="app" id="app" value="slideshow">
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
                            <th><?=Html::sortableLink("url", "Url");?></th>
                            <th><?=Html::sortableLink("dateInsert", "Fecha creación");?></th>
                            <th><?=Html::sortableLink("dateUpdate", "Fecha actualización");?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $slide) { ?>
                            <tr>
                                <td><?=$slide->id;?></a></td>
                                <td>
                                    <?php if ($slide->visible) { ?>
                                        <span class="glyphicon glyphicon-eye-open" title="Visible" alt="Visible"></span>
                                    <?php } ?>
                                    <a href="<?=Url::site("admin/slideshow/edit/".$slide->id);?>">
                                        <?=Helper::sanitize($slide->nombre);?>
                                    </a>
                                </td>
                                <td>
                                    <a href="<?=$slide->url;?>" target="_blank">
                                        <?=Helper::sanitize($slide->url);?>
                                    </a>
                                </td>
                                <td><?=Helper::humanDate($slide->dateInsert);?></td>
                                <td><?=Helper::humanDate($slide->dateUpdate);?></td>
                                <td>
                                    <?=HTML::formLink("btn-xs btn-primary", "pencil", Url::site("admin/slideshow/edit/".$slide->id)); ?>
                                    <?=HTML::formLink("btn-xs btn-danger", "remove", Url::site("admin/slideshow/delete/".$slide->id), null, null, "¿Deseas eliminar esta slide?"); ?>
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
                <p>No se han encontrado slides</p>
            </blockquote>
        <?php } ?>
    </form>
</div>
