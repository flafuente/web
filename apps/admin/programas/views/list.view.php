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
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $programa) { ?>
                            <?php $categoria = new Categoria($programa->categoriaId); ?>
                            <?php $categoria = new Categoria($programa->categoriaId); ?>
                            <tr>
                                <td><?=$programa->id;?></a></td>
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
