<?php defined('_EXE') or die('Restricted access'); ?>

<?php
$toolBar['title'] = "Categorías";
$toolBar['subtitle'] = "Listar";
$toolBar['class'] = "bookmark";
$toolBar['buttons'][] = array(
    "buttonClass" => "success",
    "spanClass" => "plus",
    "title" => "Nueva",
    "app" => "catgegorias",
    "action" => "edit",
);
$controller->setData("toolBar", $toolBar);
echo $controller->view("modules.toolbar");
?>

<div class="main">
    <form method="post" action="<?=Url::site()?>" id="mainForm" name="mainForm" class="form-inline" role="form">
        <input type="hidden" name="router" id="router" value="admin">
        <input type="hidden" name="app" id="app" value="catgegorias">
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
                        <?php foreach ($results as $categoria) { ?>
                            <tr>
                                <td><?=$categoria->id;?></a></td>
                                <td>
                                    <a href="<?=Url::site("admin/categorias/edit/".$categoria->id);?>">
                                        <?=Helper::sanitize($categoria->nombre);?>
                                    </a>
                                </td>
                                <td><?=Helper::humanDate($categoria->dateInsert);?></td>
                                <td><?=Helper::humanDate($categoria->dateUpdate);?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php $controller->setData("pag", $pag); ?>
                <?=$controller->view("modules.pagination");?>
            </div>
        <?php } else { ?>
            <blockquote>
                <p>No se han encontrado cateogorías</p>
            </blockquote>
        <?php } ?>
    </form>
</div>
