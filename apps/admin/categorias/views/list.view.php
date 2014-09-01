<?php defined('_EXE') or die('Restricted access'); ?>

<?php
//Toolbar
Toolbar::addTitle("Categorías", "glyphicon-bookmark", "Listar");
//Delete button
Toolbar::addButton(
    array(
        "title" => "Nueva",
        "app" => "categorias",
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
        <input type="hidden" name="app" id="app" value="categorias">
        <input type="hidden" name="action" id="action" value="">
        <input type="hidden" name="tipoId" id="tipoId" value="<?=(int) $_REQUEST["tipoId"];?>">
        <!-- Filters -->
        <div class="row filters">
            <!-- Search -->
            <div class="col-sm-3 col-xs-6 filter">
                <?=HTML::search();?>
            </div>
        </div>

        <!-- Tipos -->
        <ul class="nav nav-tabs" role="tablist">
            <?php $categoriaNull = new Categoria(); ?>
            <?php foreach ($categoriaNull->tipos as $tipoId=>$tipoString) { ?>
                <li class="<?php echo ($_REQUEST["tipoId"] == $tipoId) ? "active" : ""; ?>">
                    <a href="#" data-id="<?=$tipoId;?>" class="tabLink">
                        <?=$tipoString;?>
                    </a>
                </li>
            <?php } ?>
        </ul>

        <?php if (count($results)) { ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><?=Html::sortableLink("id", "Id");?></th>
                            <th><?=Html::sortableLink("nombre", "Nombre");?></th>
                            <th><?=Html::sortableLink("color", "Color");?></th>
                            <th><?=Html::sortableLink("dateInsert", "Fecha creación");?></th>
                            <th><?=Html::sortableLink("dateUpdate", "Fecha actualización");?></th>
                            <th></th>
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
                                <td style="background-color: <?=Helper::sanitize($categoria->color);?>">
                                    <?=Helper::sanitize($categoria->color);?>
                                </td>
                                <td><?=Helper::humanDate($categoria->dateInsert);?></td>
                                <td><?=Helper::humanDate($categoria->dateUpdate);?></td>
                                <td>
                                    <?=HTML::formLink("btn-xs btn-primary", "pencil", Url::site("admin/categorias/edit/".$categoria->id)); ?>
                                    <?=HTML::formLink("btn-xs btn-danger", "remove", Url::site("admin/categorias/delete/".$categoria->id), null, null, "¿Deseas eliminar esta categoría?"); ?>
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
                <p>No se han encontrado cateogorías</p>
            </blockquote>
        <?php } ?>
    </form>
</div>

<script>
    $(document).on('click', '.tabLink', function (e) {
        $("#tipoId").val($(this).attr("data-id"));
        $("#mainForm").submit();
    });
</script>
