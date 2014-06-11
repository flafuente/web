<?php defined('_EXE') or die('Restricted access'); ?>

<?php
$toolBar['title'] = "Tags";
$toolBar['subtitle'] = "Listar";
$toolBar['class'] = "asterisk";
$toolBar['buttons'][] = array(
    "buttonClass" => "success",
    "spanClass" => "plus",
    "title" => "Nuevo",
    "app" => "tags",
    "action" => "edit",
);
$controller->setData("toolBar", $toolBar);
echo $controller->view("modules.toolbar");
?>

<div class="main">
    <form method="post" action="<?=Url::site()?>" id="mainForm" name="mainForm" class="form-inline" role="form">
        <input type="hidden" name="router" id="router" value="admin">
        <input type="hidden" name="app" id="app" value="tags">
        <input type="hidden" name="action" id="action" value="">
        <?php if (count($results)) { ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><?=Helper::sortableLink("id", "Id");?></th>
                            <th><?=Helper::sortableLink("nombre", "Nombre");?></th>
                            <th><?=Helper::sortableLink("dateInsert", "Fecha creación");?></th>
                            <th><?=Helper::sortableLink("dateUpdate", "Fecha actualización");?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $tags) { ?>
                            <tr>
                                <td><?=$tags->id;?></a></td>
                                <td>
                                    <a href="<?=Url::site("admin/tags/edit/".$tags->id);?>">
                                        <?=Helper::sanitize($tags->nombre);?>
                                    </a>
                                </td>
                                <td><?=Helper::humanDate($tags->dateInsert);?></td>
                                <td><?=Helper::humanDate($tags->dateUpdate);?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php $controller->setData("pag", $pag); ?>
                <?=$controller->view("modules.pagination");?>
            </div>
        <?php } else { ?>
            <blockquote>
                <p>No se han encontrado tags</p>
            </blockquote>
        <?php } ?>
    </form>
</div>