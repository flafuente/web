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
						<form class="l_form" action="http://interacis.com/login" method="POST"> 
							<div class="col-md-12"><input class="form-control" type="text" name="user" placeholder="Usuario" value="" /></div>
							<div class="col-md-12"><input class="form-control" type="password" name="passw" placeholder="Password"></div>
							<div class="forgot col-md-8"><a href="#">¿has olvidado tu contraseña?</a></div>
							<div class="col-md-4 l-right"><button type="submit" class="btn btn-tribo-blue ladda-button">Entra</button></div>
							<div style="clear: both;"></div>
						</form>
					</div>


					<a class='rsep' href='#'>
						<img src='<?=Url::template("/img/lupa.png");?>' title='Buscar' />
					</a>
					<a class='rsep' href='#'>
						<img src='<?=Url::template("/img/contact.png");?>' title='Contacta' />
					</a>
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
        $(document).on("click",".mask",function(){
        	//$('.login_form').add('.mask').fadeOut();
        	$('.feedback_popup').add('.login_form').add('.mask').fadeOut();
        });
    </script>
    <!-- /.container -->