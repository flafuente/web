<?php defined('_EXE') or die('Restricted access');

?>

	<div class='title-line'>
		<span>ÚLTIMAS NOTICIAS</span>
	</div>

	<?php

	seeProgram("not01.jpg", "INUNDACIONES EN CUENCA", "periodismociudadano/inundaciones");
	seeProgram("not01.jpg", "MANIFESTACIÓN DE MARCHAS ANTIGLOBALIZACIÓN", "periodismociudadano/manifestaciones");
	seeProgram("not01.jpg", "PROCLAMACIÓN FELIPE VI", "periodismociudadano/proclamacion");
	seeProgram("not01.jpg", "PROTESTAS REPUBLICANAS", "periodismociudadano/protestas");


	?>
	<div class="col-md-offset-6 col-md-6 ver-todas-web">
		Ver histórico de noticias&nbsp;&nbsp;<div class="circulo-azul">+</div>
	</div>

<div style="clear: both;"></div>
<br /><br />
<div class='col-md-12'>
	<div class='video-info' style="padding: 5px;">
		<div class='title-line'>
			<span>LOCALIZACIÓN TRIBERS</span>
		</div>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
		<div style="overflow:hidden;height:300px;">
			<div id="gmap_canvas" style="height:300px;"></div>
		</div>
		<script type="text/javascript">
			function init_map(){
				var myOptions = {
					zoom:5,
					center:new google.maps.LatLng(38.09690980000001,-3.6369803000000047),
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					styles: [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#193341"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#2c5a71"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#29768a"},{"lightness":-37}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#3e606f"},{"weight":2},{"gamma":0.84}]},{"elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"weight":0.6},{"color":"#1a3541"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#2c5a71"}]}]
                
				};
				map = new google.maps.Map(document.getElementById("gmap_canvas"), myOptions);
				
				<?= markerMaps("triber1", "38.09690980000001", "-3.6369803000000047", "<b>Triber01</b><br/>Rio Tamesi<br/> Linares"); ?>
				<?= markerMaps("triber2", "41.90429719999999", "-1.7222534999999652", "<b>Triber02</b><br/>Tarazona<br/> Zaragoza"); ?>

			}
			google.maps.event.addDomListener(window, 'load', init_map);
		</script>

	</div>
</div>
<div style="clear: both;"></div>
<br /><br />
<div class='col-md-12'>
	<div class='video-info' style="padding: 5px;">
		<div class='title-line'>
			<span>HAZTE TRIBER</span>
		</div>
		<div class="col-md-12 video">
		</div>
		<div style="clear: both;"></div>
		<br />
		<div class="haztetriber_title">
			¿QUIERES SER TRIBER Y TRABAJAR CON NOSOTROS?
		</div>
		<br />
		<div class="haztetriber_description">
			Bueno… Triber ya eres, porque te gusta internet, porque te gusta ver y hacer vídeos, fotos y además subirlas, porque disfrutas de las redes sociales, y sobre todo, porque te lo pasas bien.
			<br /><br />
			Pues ya está, vente a Tribo porque buscamos gente  que nos envíe sus videos, cace noticias al vuelo, que controle las redes sociales y que le encante el mundo on line.
			<br /><br />
			Queremos sumar los mejores buscadores de contenidos, supporters del on line que sean fánaticos de internet. Bloggers, nativos digitales y profesionales, capaces de ver más allá del mainstreim, detectores de filones y capaces de generar tendencia y viralidad con sus búsquedas.
		</div>
		<div style="clear: both;"></div>
		<br /><br />


		<div class="well">
			<fieldset>
				<form class="form-horizontal" role="form" method="post" name="loginForm" id="loginForm" action="">
					<div class="form-group">
					    <label for="user" class="col-sm-offset-1 col-sm-3 control-label l-left"><img src="<?=Url::template("img/haztetriber/user.png");?>" />&nbsp;&nbsp;Usuario</label>
					    <div class="col-sm-8">
					    	<input type="text" class="form-control" id="user" name="user" />
					    </div>
					</div>
					<div class="form-group">
					    <label for="passw" class="col-sm-offset-1 col-sm-3 control-label l-left"><img src="<?=Url::template("img/haztetriber/passw.png");?>" />&nbsp;&nbsp;Contraseña</label>
					    <div class="col-sm-8">
					    	<input type="password" class="form-control" id="passw" name="passw" />
					    </div>
					</div>
					<div class="form-group">
					    <label for="email" class="col-sm-offset-1 col-sm-3 control-label l-left"><img src="<?=Url::template("img/haztetriber/email.png");?>" />&nbsp;&nbsp;Email</label>
					    <div class="col-sm-8">
					    	<input type="text" class="form-control" id="email" name="email" />
					    </div>
					</div>
					<!-- Buttons -->
					<div class="form-group">
					    <div class="col-sm-offset-1 col-sm-2 l-left">
					    	<button class="btn btn-tribo-grey ladda-button" data-style="slide-left">Regístrate</button>
					    </div>
					    <div class="col-sm-9 l-right">
					    	<span class="yareg">Si ya estás registrado, accede como usuario:</span>
					    	<button class="btn btn-tribo-blue ladda-button" data-style="slide-left">Entrar</button>
					    </div>
					</div>
				</form>
			</fieldset>
		</div>


		<div style="clear: both;"></div>
		<br /><br />
		<div class="haztetriber_contacta">
		También puesdes ponerte en contacto con nosotros en:
		<br />
		<a href="mailto:info@tribo.tv">info@tribo.tv</a>
		</div>

	</div>

</div>







<?php
function seeProgram($img, $title, $url){
	?>
	<div class='col-md-6 square'>
		<img src="<?=Url::template("img/noticias/".$img)?>" title="<?php echo $title; ?>" />
		<img class="arrow" src="<?=Url::template("img/arrow.png")?>" />
		<div class="sq_content">
			<div class="sq_title">
				<a href="<?=Url::site($url);?>">
				<?php echo $title; ?>
				</a>
			</div>
		</div>
	</div>
	<?php
}

function markerMaps($name, $lat, $long, $html){
	$mark =  $name.' = new google.maps.Marker({map: map, position: new google.maps.LatLng('.$lat.', '.$long.')});
			 infowindow'.$name.' = new google.maps.InfoWindow({content:"'.$html.'" });
			 google.maps.event.addListener('.$name.', "click", function(){
				 infowindow'.$name.'.open(map,'.$name.');
			 });
			 infowindow'.$name.'.open(map,'.$name.');';
	return $mark;
}