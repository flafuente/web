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
        "link" => Url::site("admin/users"),
        "class" => "primary",
        "spanClass" => "chevron-left",
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
    <input type="hidden" name="action" id="action" value="save">
    <input type="hidden" name="id" value="<?=$user->id?>">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Cuenta
                </div>
                <div class="panel-body">
                    <!-- Estado -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            Estado
                        </label>
                        <div class="col-sm-8">
                            <input type="hidden" name="statusId" value="0">
                            <input type="checkbox" class="switch" name="statusId" id="statusId" value="1" <?php if($user->statusId) echo "checked";?>>
                        </div>
                    </div>
                    <!-- Rol -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            Rol
                        </label>
                        <div class="col-sm-8">
                            <?=HTML::select("roleId", $user->roles, $user->roleId, array("id" => "roleId")); ?>
                        </div>
                    </div>
                    <!-- Accesos -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            Accesos
                        </label>
                        <div class="col-sm-8">
                            <?php $permisos = $user->getPermisos(); ?>
                            <?=HTML::select("permisos[]", $user->secciones, $permisos, array("class" => "select2", "multiple" => "true")); ?>
                        </div>
                    </div>
                    <!-- Categorías -->
                    <?php if (is_array($categorias) && count($categorias)) { ?>
                        <div class="form-group" id="fieldCategoria" style="display:none">
                            <label class="col-sm-3 control-label">
                                Categoría
                            </label>
                            <div class="col-sm-8">
                                <?php $categoriasUser = $user->getCategoriasIds(); ?>
                                <?=HTML::select("categorias[]", $categorias, $categoriasUser, array("class" => "select2", "multiple" => "true"), null, array("display" => "nombre")); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- Email -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            Email
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="email" name="email" class="form-control" value="<?=Helper::sanitize($user->email);?>">
                        </div>
                    </div>
                    <!-- Contraseña -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            Contraseña
                        </label>
                        <div class="col-sm-8">
                            <input type="password" id="password" name="password" class="form-control">
                        </div>
                    </div>
                    <!-- Username -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            Alias
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="username" name="username" class="form-control" value="<?=Helper::sanitize($user->username);?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Datos personales
                </div>
                <div class="panel-body">
                    <!-- Foto -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            Foto
                        </label>
                        <div class="col-sm-3">
                            <img src="<?=$user->getFotoUrl();?>" width="100%">
                            <?php if ($user->foto) { ?>
                                <input type="checkbox" value="1" name="deleteFoto"> Eliminar
                            <?php } ?>
                        </div>
                    </div>
                    <!-- Nombre -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            Nombre
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="nombre" name="nombre" class="form-control" value="<?=Helper::sanitize($user->nombre);?>">
                        </div>
                    </div>
                    <!-- Apellidos -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            Apellidos
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="apellidos" name="apellidos" class="form-control" value="<?=Helper::sanitize($user->apellidos);?>">
                        </div>
                    </div>
                    <!-- Ubicacion -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            Ubicacion
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="ubicacion" name="ubicacion" class="form-control" value="<?=Helper::sanitize($user->ubicacion);?>">
                        </div>
                    </div>
                    <!-- Biografía -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            Biografía
                        </label>
                        <div class="col-sm-8">
                            <textarea id="biografia" name="biografia" class="form-control"><?=Helper::sanitize($user->biografia);?></textarea>
                        </div>
                    </div>
                    <!-- Teléfono -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            Teléfono
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="telefono" name="telefono" class="form-control" value="<?=Helper::sanitize($user->telefono);?>">
                        </div>
                    </div>
                    <!-- Sitios -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            Sitios
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="sitios" name="sitios" class="form-control" value="<?=Helper::sanitize($user->sitios);?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    2 Factor Auth
                </div>
                <div class="panel-body">
                    <!-- 2FA Status -->
                    <div class="form-group">
                        <label class="col-sm-5 control-label">
                            2FA Status
                        </label>
                        <div class="col-sm-7">
                            <input type="hidden" name="tfaStatus" value="0">
                            <input type="checkbox" class="switch" name="tfaStatus" id="tfaStatus" value="1" <?php if($user->tfaStatus) echo "checked";?>>
                        </div>
                    </div>
                    <!-- 2FA Status -->
                    <div class="form-group 2fa">
                        <div class="col-sm-12">
                            <?php $ga = new PHPGangsta_GoogleAuthenticator(); ?>
                            <?php $config = Registry::getConfig(); ?>
                            <img width="100%" src="<?=$ga->getQRCodeGoogleUrl($user->email.' @ '.$config->get("2faCode"), $user->tfaSecret);?>">
                        </div>
                    </div>
                    <!-- Code -->
                    <div class="form-group 2fa">
                        <div class="col-sm-12">
                            <input type="text" id="2faCode" name="2faCode" class="form-control">
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
    //Sitios
    $("#sitios").select2({
        tags:[],
        tokenSeparators: [",", " "]
    });

    $('#tfaStatus').on('switchChange.bootstrapSwitch', function (event, state) {
        if (this.checked) {
            $(".2fa").show();
        } else {
            $(".2fa").hide();
        }
    });
    $("#tfaStatus").change();
</script>
