<?php defined('_EXE') or die('Restricted access'); ?>

<div class="well">
	<fieldset>
		<legend>
			Regístrate en tribo
		</legend>
		<form class="form-horizontal ajax" role="form" method="post" name="registerForm" id="registerForm" action="<?=Url::site("login/doRegister")?>">
			<!-- Nombre -->
			<div class="form-group">
			    <label for="nombre" class="col-sm-2 control-label">
			    	Nombre
			    </label>
			    <div class="col-sm-10">
			    	<input type="text" class="form-control" id="nombre" name="nombre">
			    </div>
			</div>
			<!-- Apellidos -->
			<div class="form-group">
			    <label for="apellidos" class="col-sm-2 control-label">
			    	Apellidos
			    </label>
			    <div class="col-sm-10">
			    	<input type="text" class="form-control" id="apellidos" name="apellidos">
			    </div>
			</div>
			<!-- Email -->
			<div class="form-group">
			    <label for="email" class="col-sm-2 control-label">
			    	Email
			    </label>
			    <div class="col-sm-10">
			    	<input type="text" class="form-control" id="email" name="email">
			    </div>
			</div>
			<!-- Password -->
			<div class="form-group">
			    <label for="password" class="col-sm-2 control-label">
			    	Contraseña
			    </label>
			    <div class="col-sm-10">
			    	<input type="password" class="form-control" id="password" name="password">
			    </div>
			</div>
			<!-- Password2 -->
			<div class="form-group">
			    <label for="password2" class="col-sm-2 control-label">
			    	Repetir contraseña
			    </label>
			    <div class="col-sm-10">
			    	<input type="password" class="form-control" id="password2" name="password2">
			    </div>
			</div>
			<!-- Buttons -->
			<div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			    	<button type="submit" class="btn btn-primary">
			    		Registrar
			    	</button>
			    </div>
			</div>
		</form>
	</fieldset>
</div>