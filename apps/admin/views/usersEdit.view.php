<?php defined('_EXE') or die('Restricted access'); ?>

<?php $currentUser = Registry::getUser();?>

<?php
if($user->id){
	$toolBar['subtitle'] = "Editar usuario";
	$title = "Guardar";
}else{
	$toolBar['subtitle'] = "Nuevo usuario";
	$title = "Crear";
}
$toolBar['title'] = "Usuarios";
$toolBar['class'] = "user";
$toolBar['buttons'][] = array(
    "buttonClass" => "success",
    "spanClass" => "ok",
    "title" => $title,
    "app" => "admin",
    "action" => "usersSave",
);
$toolBar['buttons'][] = array(
    "buttonClass" => "primary",
    "spanClass" => "chevron-left",
    "title" => "Cancelar",
    "app" => "admin",
    "action" => "users",
    "noAjax" => true,
);
if($video->id){
	$toolBar['buttons'][] = array(
	    "buttonClass" => "danger",
	    "spanClass" => "remove",
	    "title" => "Eliminar",
	    "app" => "admin",
	    "action" => "usersDelete",
	    "confirmation" => "¿Deseas realmente eliminar este usuario?",
	);
}
$controller->setData("toolBar", $toolBar);
echo $controller->view("modules.toolbar");
?>

<form method="post" name="mainForm" id="mainForm" action="<?=Url::site();?>" class="form-horizontal ajax" role="form" autocomplete="off">
	<input type="hidden" name="app" id="app" value="admin">
	<input type="hidden" name="action" id="action" value="usersSave">
	<input type="hidden" name="id" value="<?=$user->id?>">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Detalles
				</div>
			  	<div class="panel-body">
			    	<div class="form-group">
						<label class="col-sm-2 control-label">
							Estado
						</label>
						<div class="col-sm-10">
							<input type="checkbox" class="switch" name="statusId" id="statusId" value="1" <?php if($user->statusId) echo "checked";?>>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">
							Rol
						</label>
						<div class="col-sm-8">
							<select class="form-control" name="roleId" id="roleId">
								<?php $s = array(); ?>
								<?php $s[$user->roleId] = "selected"; ?>
								<?php foreach($user->roles as $roleId=>$roleString){ ?>
									<?php if($currentUser->roleId>$roleId || $currentUser->roleId>=2){ ?>
										<option value="<?=$roleId?>" <?=$s[$roleId]?>>
											<?=$roleString;?>
										</option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">
							Accesos
						</label>
						<div class="col-sm-8">
							<select class="form-control select2" name="permisos[]" id="permisos" multiple="true">
								<?php $s = array(); ?>
								<?php foreach($user->secciones as $seccionId=>$seccionString){ ?>
									<?php $permisos = json_decode($user->permisos); ?>
									<?php $selected = ""; ?>
									<?php if(@in_array($seccionId, $permisos)){ ?>
										<?php $selected = "selected"; ?>
									<?php } ?>
									<option value="<?=$seccionId?>" <?=$selected?>>
										<?=$seccionString;?>
									</option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">
							Nombre
						</label>
						<div class="col-sm-8">
							<input type="text" id="nombre" name="nombre" class="form-control" value="<?=Helper::sanitize($user->nombre);?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">
							Apellidos
						</label>
						<div class="col-sm-8">
							<input type="text" id="apellidos" name="apellidos" class="form-control" value="<?=Helper::sanitize($user->apellidos);?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">
							Email
						</label>
						<div class="col-sm-8">
							<input type="text" id="email" name="email" class="form-control" value="<?=Helper::sanitize($user->email);?>">
						</div>
					</div>
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