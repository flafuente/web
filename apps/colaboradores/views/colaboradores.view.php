<?php defined('_EXE') or die('Restricted access');

?>
<div class='col-md-12 serie_info'>
	<div class="col-md-12 video">
    </div>
	<div style="clear: both;"></div>
	<br />
	<div class="haztetriber_title">
		¿Tienes contenido en internet y quieres que se vea en televisión?
	</div>
	<br />
	<div class="haztetriber_description">
		Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.
		<br /><br />
		Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus.
		<br /><br />
		Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. 	
	</div>
	<div style="clear: both;"></div>
	<br /><br />


	<div class="well">
		<div class="well_title">
			¿Tienes alguna consulta o algo que enseñarnos?
		</div>
		<fieldset>
			<form class="form-horizontal" role="form" method="post" name="loginForm" id="loginForm" action="">
				<div class="form-group">
				    <label for="user" class="col-sm-offset-1 col-sm-3 control-label l-left"><img src="<?=Url::template("img/haztetriber/user.png");?>" />&nbsp;&nbsp;Nombre</label>
				    <div class="col-sm-4">
				    	<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" />
				    </div>
				    <div class="col-sm-4">
				    	<input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos" />
				    </div>
				</div>
				<div class="form-group">
				    <label for="email" class="col-sm-offset-1 col-sm-3 control-label l-left"><img src="<?=Url::template("img/haztetriber/email.png");?>" />&nbsp;&nbsp;Email</label>
				    <div class="col-sm-8">
				    	<input type="text" class="form-control" id="email" name="email" placeholder="Email" />
				    </div>
				</div>
				<div class="form-group">
				    <label for="email" class="col-sm-offset-1 col-sm-3 control-label l-left"><img src="<?=Url::template("img/haztetriber/telefono.png");?>" />&nbsp;&nbsp;Teléfono</label>
				    <div class="col-sm-8">
				    	<input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" />
				    </div>
				</div>
				<div class="form-group">
				    <label for="email" class="col-sm-offset-1 col-sm-3 control-label l-left"><img src="<?=Url::template("img/haztetriber/mensaje.png");?>" />&nbsp;&nbsp;Mensaje</label>
				    <div class="col-sm-8">
				    	<textarea id="mensaje" name="mensaje" placeholder="Mensaje" style="width: 100%; min-height: 100px;"></textarea>
				    </div>
				</div>
				<div class="form-group">
				    <label for="email" class="col-sm-offset-1 col-sm-3 control-label l-left"><img src="<?=Url::template("img/haztetriber/url.png");?>" />&nbsp;&nbsp;Url</label>
				    <div class="col-sm-8">
				    	<input type="text" class="form-control" id="url" name="url" placeholder="Url" />
				    </div>
				</div>
				<div class="form-group">
				    <label for="email" class="col-sm-offset-1 col-sm-3 control-label l-left"><img src="<?=Url::template("img/haztetriber/seccion.png");?>" />&nbsp;&nbsp;Sección</label>
				    <div class="col-sm-8">
				    	<select class="form-control" id="seccion" name="seccion">
				    		<?php
				    		for($x=0; $x<15; $x++){
				    			?><option value="seccion<?= ($x+1); ?>">Seccion <?= ($x+1); ?></option><?php
				    		}
				    		?>
				    	</select>
				    </div>
				</div>
				<!-- Buttons -->
				<div class="form-group">
				    <div class="col-sm-12 l-right">
				    	<button class="btn btn-tribo-blue ladda-button" data-style="slide-left">Enviar</button>
				    </div>
				</div>
			</form>
		</fieldset>
	</div>
    <div class="col-sm-12 l-right">
   		<span class="yareg">O si ya eres colaborador, accede con tu cuenta:</span>
    	<button class="btn btn-tribo-grey ladda-button" data-style="slide-left">Accede</button>
    </div>
</div>

