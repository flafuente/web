<?php defined('_EXE') or die('Restricted access'); ?>

<?php $user = Registry::getUser();?>

<h1>
	<span class="glyphicon glyphicon-wrench"></span>
	Perfil
</h1>

<div class="main">
	<form method="post" action="<?=Url::site();?>" class="form-horizontal ajax" role="form" autocomplete="off">
		<input type="hidden" name="app" id="app" value="perfil">
		<input type="hidden" name="action" id="action" value="save">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						Cuenta
					</div>
				  	<div class="panel-body">
						<!-- Email -->
						<div class="form-group">
							<label class="col-sm-2 control-label">
								Email
							</label>
							<div class="col-sm-10">
								<input type="text" id="email" name="email" class="form-control" value="<?=Helper::sanitize($user->email);?>">
							</div>
						</div>
						<!-- Password -->
						<div class="form-group">
							<label class="col-sm-2 control-label">
								Contraseña
							</label>
							<div class="col-sm-10">
								<input type="password" id="password" name="password" class="form-control">
							</div>
						</div>
						<!-- Buttons -->
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<a class="btn btn-default ladda-button" data-spinner-color="#000" data-style="slide-left" href="<?=Url::site();?>">
									<span class="ladda-label">
										Cancelar
									</span>
								</a>
								<button class="btn btn-primary ladda-button" data-style="slide-left">
									<span class="ladda-label">
										Guardar
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