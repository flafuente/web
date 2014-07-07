<?php defined('_EXE') or die('Restricted access'); ?>

<?php $currentUser = Registry::getUser();?>

<?php
//Toolbar
if ($user->id) {
    $subtitle = "Editar usuario";
    $title = "Guardar";
} else {
    $subtitle = "Nuevo usuario";
    $title = "Crear";
}
Toolbar::addTitle("Usuarios", "glyphicon-user", $subtitle);
if ($user->id) {
    //Delete button
    Toolbar::addButton(
        array(
            "title" => "Eliminar",
            "app" => "users",
            "action" => "delete",
            "class" => "danger",
            "spanClass" => "remove",
            "confirmation" => "¿Deseas realmente eliminar este usuario?",
            "noAjax" => true,
        )
    );
}
//Cancel button
Toolbar::addButton(
    array(
        "title" => "Cancelar",
        "app" => "users",
        "action" => "index",
        "class" => "primary",
        "spanClass" => "chevron-left",
        "noAjax" => true,
    )
);
//Save button
Toolbar::addButton(
    array(
        "title" => $title,
        "app" => "users",
        "action" => "save",
        "class" => "success",
        "spanClass" => "ok",
    )
);
Toolbar::render();
?>

<form method="post" name="mainForm" id="mainForm" action="<?=Url::site();?>" class="form-horizontal ajax" role="form" autocomplete="off">
    <input type="hidden" name="router" id="router" value="admin">
    <input type="hidden" name="app" id="app" value="users">
    <input type="hidden" name="action" id="action" value="usersSave">
    <input type="hidden" name="id" value="<?=$user->id?>">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Detalles
                </div>
                <div class="panel-body">
                    <!-- Estado -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Estado
                        </label>
                        <div class="col-sm-10">
                            <input type="hidden" name="statusId" value="0">
                            <input type="checkbox" class="switch" name="statusId" id="statusId" value="1" <?php if($user->statusId) echo "checked";?>>
                        </div>
                    </div>
                    <!-- Rol -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Rol
                        </label>
                        <div class="col-sm-8">
                            <?=HTML::select("roleId", $user->roles, $user->roleId, array("id" => "roleId")); ?>
                        </div>
                    </div>
                    <!-- Accesos -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Accesos
                        </label>
                        <div class="col-sm-8">
                            <?php $permisos = $user->getCategoriasIds(); ?>
                            <?=HTML::select("permisos[]", $user->secciones, $permisos, array("class" => "select2", "multiple" => "true")); ?>
                        </div>
                    </div>
                    <!-- Categorías -->
                    <?php if (is_array($categorias) && count($categorias)) { ?>
                        <div class="form-group" id="fieldCategoria" style="display:none">
                            <label class="col-sm-2 control-label">
                                Categoría
                            </label>
                            <div class="col-sm-8">
                                <?php $categoriasUser = $user->getCategoriasIds(); ?>
                                <?=HTML::select("categorias[]", $categorias, $categoriasUser, array("class" => "select2", "multiple" => "true"), null, array("display" => "nombre")); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- Nombre -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Nombre
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="nombre" name="nombre" class="form-control" value="<?=Helper::sanitize($user->nombre);?>">
                        </div>
                    </div>
                    <!-- Apellidos -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Apellidos
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="apellidos" name="apellidos" class="form-control" value="<?=Helper::sanitize($user->apellidos);?>">
                        </div>
                    </div>
                    <!-- Email -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Email
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="email" name="email" class="form-control" value="<?=Helper::sanitize($user->email);?>">
                        </div>
                    </div>
                    <!-- Contraseña -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Contraseña
                        </label>
                        <div class="col-sm-8">
                            <input type="password" id="password" name="password" class="form-control">
                        </div>
                    </div>
                    <!-- Username -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Alias
                        </label>
                        <div class="col-sm-10">
                            <input type="text" id="username" name="username" class="form-control" value="<?=Helper::sanitize($user->username);?>">
                        </div>
                    </div>
                    <!-- Sexo -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Sexo
                        </label>
                        <div class="col-sm-10">
                            <?php $s = array();?>
                            <?php $s[$user->sexo]; ?>
                            <input type="radio" goup="sexo" name="sexo" id="sexo1" value="1" <?=$s[1]?>>
                            Femenino
                            <input type="radio" goup="sexo" name="sexo" id="sexo2" value="2" <?=$s[1]?>>
                            Masculino
                        </div>
                    </div>
                    <!-- Cumpleaños -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Cumpleaños
                        </label>
                        <div class="col-sm-10">
                            <input type="date" id="fechaNacimiento" name="fechaNacimiento" class="form-control" value="<?=date("m/d/Y", strtotime($user->fechaNacimiento));?>">
                        </div>
                    </div>
                    <!-- Ubicacion -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Ubicacion
                        </label>
                        <div class="col-sm-10">
                            <input type="text" id="ubicacion" name="ubicacion" class="form-control" value="<?=Helper::sanitize($user->ubicacion);?>">
                        </div>
                    </div>
                    <!-- Biografía -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Biografía
                        </label>
                        <div class="col-sm-10">
                            <textarea id="biografia" name="biografia" class="form-control"><?=Helper::sanitize($user->biografia);?></textarea>
                            <br>
                            <input type="text" id="intereses" name="intereses" class="form-control" value="<?=Helper::sanitize($user->intereses);?>">
                        </div>
                    </div>
                    <!-- Formación y empleo -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Formación y empleo
                        </label>
                        <div class="col-sm-10">
                            <input type="text" id="trabajo" name="trabajo" class="form-control" value="<?=Helper::sanitize($user->trabajo);?>">
                            <br>
                            <input type="text" id="estudios" name="estudios" class="form-control" value="<?=Helper::sanitize($user->estudios);?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).on('change', '#roleId', function (e) {
        roleChange();
    });
    $(document).ready(function () {
        roleChange();
    });
    function roleChange()
    {
        $("#fieldCategoria").hide();
        if ($("#roleId").val()==<?=USER_ROLE_VALIDADOR?> || $("#roleId").val()==<?=USER_ROLE_TRIBBER?>) {
            $("#fieldCategoria").show();
        }
    }
</script>
