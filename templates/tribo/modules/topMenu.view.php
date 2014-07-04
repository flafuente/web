<?php defined('_EXE') or die('Restricted access'); ?>

<?php $user = Registry::getUser(); ?>
<?php $config = Registry::getConfig(); ?>


    <div class="container">
		<div class="row-fluid">
			<div class='col-md-4 topleft'>
				<div class='col-md-12 pull-left mid'>
					<a class='rsep login' href='#'>
						<img src='<?=Url::template("/img/user.png");?>' title='Login' />
					</a>
					<div class="login_form" style="display: none;">
						<div class="forgot col-md-8"><img style="float: left;" src='<?=Url::template("/img/user.png");?>' title='Login' /><h1>&nbsp;&nbsp;&nbsp;ZONA TRIBER</h1></div>
						<div class="forgot col-md-4"><button type="submit" class="btn btn-tribo-grey ladda-button">Registrate</button></div>
						<div style="clear: both;"></div>
						<br />
						<form class="l_form" action="" method="POST"> 
							<div class="col-md-12"><input class="form-control" type="text" name="user" placeholder="Usuario" value="" /></div>
							<div class="col-md-12"><input class="form-control" type="password" name="passw" placeholder="Password"></div>
							<div class="forgot col-md-8"><a href="#">¿has olvidado tu contraseña?</a></div>
							<div class="col-md-4 l-right"><button type="submit" class="btn btn-tribo-blue ladda-button">Entra</button></div>
							<div style="clear: both;"></div>
						</form>
					</div>


					<a class='rsep search' href='#'>
						<img src='<?=Url::template("/img/lupa.png");?>' title='Buscar' />
					</a>
					<div class="search_form" style="display: none;">
						<div class="forgot col-md-12"><img style="float: left;" src='<?=Url::template("/img/lupa.png");?>' title='Login' /><h1>&nbsp;&nbsp;&nbsp;BUSCADOR DE PROGRAMAS</h1></div>
						<div style="clear: both;"></div>
						<br />
						<form class="l_form" action="" method="POST"> 
							<div class="col-md-12"><input class="form-control" type="text" name="search" placeholder="Buscar..." value="" /></div>
							<div class="forgot col-md-8"></div>
							<div class="col-md-4 l-right"><button type="submit" class="btn btn-tribo-blue ladda-button">Buscar</button></div>
							<div style="clear: both;"></div>
						</form>
					</div>
					<a class='rsep contact' href='#'>
						<img src='<?=Url::template("/img/contact.png");?>' title='Contacta' />
					</a>
					<div class="contact_form" style="display: none;">
						<div class="forgot col-md-12"><img style="float: left;" src='<?=Url::template("/img/contact.png");?>' title='Login' /><h1>&nbsp;&nbsp;&nbsp;CONTACTA CON NOSOTROS</h1></div>
						<div style="clear: both;"></div>
						<br />
						<form class="l_form" action="" method="POST"> 
							<div class="col-md-12"><input class="form-control" type="text" name="name" placeholder="Nombre" value="" /></div>
							<div class="col-md-12"><input class="form-control" type="text" name="email" placeholder="Email"></div>

							<div class="col-md-12">
								<select class="form-control" name="withwho">
									<option value="all">Con quien quieres contactar</option>
									<?php
									for($x=0; $x<10; $x++){
										?><option value="<?= ($x+1); ?>">Persona <?= ($x+1); ?></option><?php
									}
									?>
								</select>
							</div>
							<div class="col-md-12">
								<textarea class="form-control" name="mensaje" placeholder="Mensaje"></textarea>
							</div>
							<div class="forgot col-md-8"></div>
							<div class="col-md-4 l-right"><button type="submit" class="btn btn-tribo-blue ladda-button">Enviar</button></div>
							<div style="clear: both;"></div>
						</form>
					</div>
				</div>
			</div>
			<div class='col-md-3  col-md-offset-1'>
				<a href='<?=Url::site("home");?>' class='logo'>
					<img src='<?=Url::template("/img/logo.png");?>' />
				</a>
			</div>
			<div class='col-md-4 topright'>
				<div class='col-md-12 mid pull-right'>
				<a class='pull-right lsep' href='#'>
					<img src='<?=Url::template("/img/twitter.png");?>' title='Twitter' />
				</a>				
				<a class='pull-right lsep' href='#'>
					<img src='<?=Url::template("/img/facebook.png");?>' title='Facebook' />
				</a>
				</div>
			</div>
		</div>
    </div>
    <script>
   		$(document).on("click",".login",function(){
        	$('.login_form').add('.mask').fadeIn();      
        });
        $(document).on("click",".contact",function(){
        	$('.contact_form').add('.mask').fadeIn();      
        });
        $(document).on("click",".search",function(){
        	$('.search_form').add('.mask').fadeIn();      
        });
        $(document).on("click",".mask",function(){
        	//$('.login_form').add('.mask').fadeOut();
        	$('.login_form').add('.contact_form').add('.search_form').add('.mask').fadeOut();
        });
    </script>
    <!-- /.container -->