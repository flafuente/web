<?php defined('_EXE') or die('Restricted access'); ?>

<?php $user = Registry::getUser();?>

<h1>
	<span class="glyphicon glyphicon-wrench"></span>
	Perfil
</h1>

<div class="main">
	<form method="post" action="<?=Url::site();?>" class="form-horizontal ajax" role="form" autocomplete="off" enctype="multipart/form-data">
		<input type="hidden" name="app" id="app" value="perfil">
		<input type="hidden" name="action" id="action" value="save">
		<div class="row">
			<div class="col-md-12">
				<!-- Foto -->
				<img src="<?=$user->getFotoUrl();?>" class="img-circle">
				<input type="file" id="foto" name="foto" accept="image/*">
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
						<input type="radio" goup="sexo" name="sexo" id="sexo2" value="2" <?=$s[2]?>>
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
						<textarea id="biografia" name="biografia" class="form-control" placeholder="Cuéntanos algo sobre tí"><?=Helper::sanitize($user->biografia);?></textarea>
						<br>
						<input type="text" id="intereses" name="intereses" class="form-control" placeholder="intereses" value="<?=Helper::sanitize($user->intereses);?>">
					</div>
				</div>
				<!-- Formación y empleo -->
				<div class="form-group">
					<label class="col-sm-2 control-label">
						Formación y empleo
					</label>
					<div class="col-sm-10">
						<input type="text" id="trabajo" name="trabajo" class="form-control" placeholder="¿Dónde has trabajado?" value="<?=Helper::sanitize($user->trabajo);?>">
						<br>
						<input type="text" id="estudios" name="estudios" class="form-control" placeholder="¿Dónde has estudiado?" value="<?=Helper::sanitize($user->estudios);?>">
					</div>
				</div>

				<!-- Buttons -->
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button class="btn btn-primary ladda-button" data-style="slide-left">
							<span class="ladda-label">
								Guardar cambios
							</span>
						</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>