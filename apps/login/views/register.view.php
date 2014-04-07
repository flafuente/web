<?php defined('_EXE') or die('Restricted access'); ?>

<div class="registro">
	<fieldset>
		<div style="width: 352px; margin: auto; margin-bottom: -40px;"><img src="<?=Url::template("/img/registro/reg_logo.png");?>" alt="registrate en tribo" title="Regístrate en tribo" /></div>
		<form class="form-horizontal ajax" role="form" method="post" name="registerForm" id="registerForm" action="<?=Url::site("login/doRegister")?>">
			<!-- Nombre -->
			<div class="form-group">
			    <label for="nombre" class="col-sm-2 control-label">
			    	Nombre
			    </label>
			    <div class="col-sm-12">
			    	<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" />
			    </div>
			</div>
			<!-- Apellidos -->
			<div class="form-group">
			    <label for="apellidos" class="col-sm-2 control-label">
			    	Apellidos
			    </label>
			    <div class="col-sm-12">
			    	<input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos" />
			    </div>
			</div>
			<!-- Email -->
			<div class="form-group">
			    <label for="email" class="col-sm-2 control-label">
			    	Email
			    </label>
			    <div class="col-sm-12">
			    	<input type="text" class="form-control" id="email" name="email" placeholder="Email" />
			    </div>
			</div>
			<!-- Password -->
			<div class="form-group">
			    <label for="password" class="col-sm-2 control-label">
			    	Contraseña
			    </label>
			    <div class="col-sm-12">
			    	<input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" />
			    </div>
			</div>
			<!-- Password2 -->
			<div class="form-group">
			    <label for="password2" class="col-sm-2 control-label">
			    	Repetir contraseña
			    </label>
			    <div class="col-sm-12">
			    	<input type="password" class="form-control" id="password2" name="password2" placeholder="Repetir contraseña" />
			    </div>
			</div>
			<!-- ACCEPT TERMS -->
			<div class="form-group">
			    <label for="password2" class="col-sm-2 control-label">
			    	Acepto los terminos
			    </label>
			    <div class="col-sm-12">
			    	<input type="checkbox" class="form-control" id="acepto" name="acepto" /> <span>Acepto las condiciones y la Política de Privacidad</span>
			    </div>
			</div>
			<!-- Buttons -->
			
			<div class="form-group">
			    <div class="col-sm-12">
		    		<div style="width: 300px; margin: auto;">
				    	<button type="submit">
				    		<img src="<?=Url::template("/img/registro/reg_bienvenido.png");?>" alt="Bienvenido a tribo" title="Bienvenido a tribo" />
				    	</button>
			    	</div>
			    </div>
			</div>
			<br />
		</form>
	</fieldset>
</div>