<?php defined('_EXE') or die('Restricted access'); ?>

<?php
//Toolbar
Toolbar::addTitle("Usuarios", "glyphicon-user", "Listar");
//Delete button
Toolbar::addButton(
    array(
        "title" => "Nuevo",
        "app" => "users",
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
        <input type="hidden" name="app" id="app" value="users">
        <input type="hidden" name="action" id="action" value="">
        <!-- Filters -->
        <div class="row filters">
            <!-- Search -->
            <div class="col-sm-3 col-xs-6 filter">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" value="<?=Helper::sanitize($_REQUEST["search"]);?>">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">Buscar</button>
                    </span>
                </div>
            </div>
            <!-- Estado -->
            <div class="col-sm-3 col-xs-6 col-md-2 filter">
                <select class="form-control change-submit" name="statusId">
                    <option value="-1">Estado</option>
                    <?php $userNull = new User(); ?>
                    <?php $s = array();$s[$_REQUEST["statusId"]] = "selected"; ?>
                    <?php foreach ($userNull->statuses as $statusId=>$estadoString) { ?>
                        <option value="<?=$statusId?>" <?=$s[$statusId]?>>
                            <?=Helper::sanitize($estadoString);?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <!-- Results -->
        <?php if (count($results)) { ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><?=Helper::sortableLink("id", "Id");?></th>
                            <th><?=Helper::sortableLink("statusId", "Estado");?></th>
                            <th><?=Helper::sortableLink("roleId", "Rol");?></th>
                            <th><?=Helper::sortableLink("email", "Email");?></th>
                            <th><?=Helper::sortableLink("nombre", "Nombre");?></th>
                            <th><?=Helper::sortableLink("apellidos", "Apellidos");?></th>
                            <th><?=Helper::sortableLink("dateInsert", "Fecha creación");?></th>
                            <th><?=Helper::sortableLink("dateUpdate", "Fecha actualización");?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $user) { ?>
                            <tr>
                                <td><?=$user->id;?></a></td>
                                <td>
                                    <span class="label label-<?=$user->getStatusCssString();?>">
                                        <?=$user->getStatusString();?>
                                    </span>
                                </td>
                                <td><?=$user->getRoleString()?></td>
                                <td>
                                    <a href="<?=Url::site("admin/users/edit/".$user->id);?>">
                                        <?=Helper::sanitize($user->email);?>
                                    </a>
                                </td>
                                <td><?=$user->nombre;?></td>
                                <td><?=$user->apellidos;?></td>
                                <td><?=Helper::humanDate($user->dateInsert);?></td>
                                <td><?=Helper::humanDate($user->dateUpdate);?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php $controller->setData("pag", $pag); ?>
                <?=$controller->view("modules.pagination");?>
            </div>
        <?php } else { ?>
            <blockquote>
                <p>No se han encontrado usuarios</p>
            </blockquote>
        <?php } ?>
    </form>
</div>
