<?php defined('_EXE') or die('Restricted access'); ?>

<?php
//Toolbar
Toolbar::addTitle("Vídeos", "facetime-video", "Listar");
//Delete button
Toolbar::addButton(
    array(
        "title" => "Nuevo",
        "app" => "videos",
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
        <input type="hidden" name="app" id="app" value="videos">
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
                            <th><?=Helper::sortableLink("userId", "Usuario");?></th>
                            <th><?=Helper::sortableLink("visitas", "Visitas");?></th>
                            <th><?=Helper::sortableLink("dateInsert", "Fecha creación");?></th>
                            <th><?=Helper::sortableLink("dateUpdate", "Fecha actualización");?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $video) { ?>
                            <?php $user = new User($video->userId); ?>
                            <?php $categoria = new Categoria($video->categoriaId); ?>
                            <tr>
                                <td><?=$video->id;?></a></td>
                                <td>
                                    <span class="label label-<?=$video->getEstadoCssString();?>">
                                        <?=$video->getEstadoString();?>
                                    </span>
                                </td>
                                <td>
                                    <?=Helper::sanitize($categoria->nombre);?>
                                </td>
                                <td>
                                    <a href="<?=Url::site("admin/videos/edit/".$video->id);?>">
                                        <?=Helper::sanitize($video->titulo);?>
                                    </a>
                                </td>
                                <td>
                                    <a href="<?=Url::site("admin/users/edit/".$user->id);?>">
                                        <?=Helper::sanitize($user->email);?>
                                    </a>
                                </td>
                                <td><?=$video->visitas;?></td>
                                <td><?=Helper::humanDate($video->dateInsert);?></td>
                                <td><?=Helper::humanDate($video->dateUpdate);?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php $controller->setData("pag", $pag); ?>
                <?=$controller->view("modules.pagination");?>
            </div>
        <?php } else { ?>
            <blockquote>
                <p>No se han encontrado videos</p>
            </blockquote>
        <?php } ?>
    </form>
</div>
