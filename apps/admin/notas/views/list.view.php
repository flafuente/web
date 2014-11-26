<?php
defined('_EXE') or die('Restricted access'); ?>

<?php
//Toolbar
Toolbar::addTitle("Notas de prensa", "glyphicon-bullhorn", "Listar");
//New button
Toolbar::addButton(
    array(
        "title" => "Nueva",
        "app" => "notas",
        "action" => "edit",
        "class" => "success",
        "spanClass" => "plus",
        "noAjax" => true,
    )
);
//Render
Toolbar::render();
?>
<div class="main">
    <form method="post" id="mainForm" name="mainForm" action="<?=Url::site();?>">
        <input type="hidden" name="router" id="router" value="admin">
        <input type="hidden" name="app" id="app" value="notas">
        <input type="hidden" name="action" id="action" value="">

        <!-- Sortable Fields-->
        <?=Html::sortInputs();?>

        <!-- Pagination Fields -->
        <?=Html::paginationInputs();?>

        <!-- Filters -->
        <div class="row filters">
            <!-- Search -->
            <div class="col-sm-3 col-xs-6 filter">
                <?=Html::search();?>
            </div>
        </div>

        <!-- Results -->
        <?php if (count($results)) { ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><?=Html::sortableLink("id", "Id");?></th>
                            <th><?=Html::sortableLink("estadoId", "Estado");?></th>
                            <th><?=Html::sortableLink("titulo", "Titulo");?></th>
                            <th><?=Html::sortableLink("fecha", "Fecha");?></th>
                            <th><?=Html::sortableLink("dateInsert", "DateInsert");?></th>
                            <th><?=Html::sortableLink("dateUpdate", "DateUpdate");?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $result) { ?>
                            <tr>
                                <td><?=$result->id;?></td>
                                <td>
                                    <span class="label label-<?=$result->getEstadoCssString();?>">
                                        <?=$result->getEstadoString();?>
                                    </span>
                                </td>
                                <td><?=Helper::sanitize($result->titulo);?></td>
                                <td><?=Helper::humanDate($result->fecha);?></td>
                                <td><?=Helper::humanDate($result->dateInsert);?></td>
                                <td><?=Helper::humanDate($result->dateUpdate);?></td>

                                <td>
                                    <?=Html::formLink("btn-xs btn-primary", "pencil", Url::site("admin/notas/edit/".$result->id)); ?>
                                    <?=Html::formLink("btn-xs btn-danger", "remove", Url::site("admin/notas/delete/".$result->id), null, null, "¿Deseas realmente eliminar esta nota?"); ?>
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
                <p>No se han encontrado notas</p>
            </blockquote>
        <?php } ?>
    </form>
</div>
