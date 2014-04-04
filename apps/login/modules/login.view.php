<?php defined('_EXE') or die('Restricted access'); ?>

<?php $user = Registry::getUser(); ?>
<?php if(!$user->id){ ?>
	<form class="form-horizontal ajax" role="form" method="post" name="loginForm" id="loginForm" action="<?=Url::site("login/doLogin")?>">
		<!-- Username -->
		<div class="form-group">
		    <div class="col-sm-10">
		    	<input type="text" class="form-control" id="login" name="login" placeholder="Email">
		    </div>
		</div>
		<!-- Password -->
		<div class="form-group">
		    <div class="col-sm-10">
		    	<input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
		    </div>
		</div>
		<!-- Buttons -->
		<div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		    	<button class="btn btn-primary ladda-button" data-style="slide-left">
					<span class="ladda-label">
		    			Acceder
		    		</span>
		    	</button>
		    	<a href="<?=Url::site("login/recovery");?>">
		    		¿Has olvidado tu acceso?
		    	</a>
		    </div>
		</div>
	</form>
<?php }else{ ?>
	<h3>Hola <?=$user->nombre?>! :)</h3>
	<a class="btn btn-primary" href="<?=Url::site("login/doLogout")?>">
		Salir
	</a>
<?php } ?>