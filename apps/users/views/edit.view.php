<?php defined('_EXE') or die('Restricted access'); ?>

<?php $currentUser = Registry::getUser();?>

<h1>
	<span class="glyphicon glyphicon-user"></span>
	Usuarios
	<small>
		<?=$user->id ? "Editar" : "Nuevo";?>
	</small>
</h1>

<div class="main">
	<form method="post" name="mainForm" id="mainForm" action="<?=Url::site();?>" class="form-horizontal ajax" role="form" autocomplete="off">
		<input type="hidden" name="app" id="app" value="users">
		<input type="hidden" name="action" id="action" value="save">
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
								<input type="checkbox" name="statusId" id="statusId" value="1" <?php if($user->statusId) echo "checked";?>>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								Rol
							</label>
							<div class="col-sm-10">
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
								Nombre
							</label>
							<div class="col-sm-10">
								<input type="text" id="nombre" name="nombre" class="form-control" value="<?=Helper::sanitize($user->nombre);?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								Apellidos
							</label>
							<div class="col-sm-10">
								<input type="text" id="apellidos" name="apellidos" class="form-control" value="<?=Helper::sanitize($user->apellidos);?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								Email
							</label>
							<div class="col-sm-10">
								<input type="text" id="email" name="email" class="form-control" value="<?=Helper::sanitize($user->email);?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								Contraseña
							</label>
							<div class="col-sm-10">
								<input type="password" id="password" name="password" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<?php if($user->id){ ?>
									<button class="btn btn-danger ladda-button delete" data-style="slide-left" confirm="<?=Registry::translate("VIEW_USERS_CONFIRM_DELETE")?>">
										<span class="ladda-label">
											Eliminar
										</span>
									</button>
								<?php } ?>
								<a class="btn btn-default ladda-button" data-spinner-color="#000" data-style="slide-left" href="<?=Url::site("users");?>">
									<span class="ladda-label">
										Cancelar
									</span>
								</a>
								<button class="btn btn-primary ladda-button" data-style="slide-left">
									<span class="ladda-label">
										<?=$user->id ? "Guardar" : "Crear";?>
									</span>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>