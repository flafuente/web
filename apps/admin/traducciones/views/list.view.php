<?php defined('_EXE') or die('Restricted access'); ?>

<?php
//Toolbar
Toolbar::addTitle("Tags", "glyphicon-glob", "Listar");
//Delete button
Toolbar::addButton(
    array(
        "title" => "Nueva",
        "app" => "traducciones",
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
        <input type="hidden" name="app" id="app" value="traducciones">
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
                            <th><?=Html::sortableLink("langId", "Idioma");?></th>
                            <th><?=Html::sortableLink("item", "Tipo");?></th>
                            <th><?=Html::sortableLink("itemId", "Item");?></th>
                            <th><?=Html::sortableLink("dateInsert", "Fecha creación");?></th>
                            <th><?=Html::sortableLink("dateUpdate", "Fecha actualización");?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $traduccion) { ?>
                            <?php
                                $class = ucfirst($traduccion->item);
                                $item = new $class($traduccion->itemId);
                            ?>
                            <tr>
                                <td><?=Helper::sanitize($traduccion->getLangString());?></td>
                                <td><?=Helper::sanitize($traduccion->getItemString());?></td>
                                <td><?=Helper::sanitize($traduccion->itemToString($item));?></td>
                                <td><?=Helper::humanDate($traduccion->dateInsert);?></td>
                                <td><?=Helper::humanDate($traduccion->dateUpdate);?></td>
                                <td>
                                    <?=HTML::formLink("btn-xs btn-primary", "pencil", Url::site("admin/traducciones/edit/".$traduccion->langId."/".$traduccion->item."/".$traduccion->itemId)); ?>
                                    <?=HTML::formLink("btn-xs btn-danger", "remove", Url::site("admin/traducciones/delete/?langId=".$traduccion->langId."&item=".$traduccion->item."&itemId=".$traduccion->itemId), null, null, "¿Deseas eliminar esta traducción?"); ?>
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
                <p>No se han encontrado traducciones</p>
            </blockquote>
        <?php } ?>
    </form>
</div>
