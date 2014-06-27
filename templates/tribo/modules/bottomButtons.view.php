<?php defined('_EXE') or die('Restricted access'); ?>
<?php

?>
<div class="col-md-1"></div>
<?php
showCircle("webseries", "webseries", "WEBSERIES", "Sección dedicada a las mejores series en internet");
showCircle("periodismo", "periodismo", "PERIODISMO CIUDADANO", "La información captada según ocurre, captada por los ciudadanos");
showCircle("moda", "moda", "MODA", "Te contamos cuáles son las últimas tendencias");
showCircle("gamers", "gamers", "GAMERS", "Previews de los últimos videojuegos, partidas en directo...");
showCircle("humor", "humor", "HUMOR", "Los contenidos más divertidos, directamente en tu sofá");
?>
<div class="col-md-1"></div>
<?php



function showCircle($icon, $url, $name, $description){
	?>
	<div class="col-md-2 circle_items">
		<a href="<?=Url::site($url); ?>">
			<div class="l_circle <?php echo $icon; ?>">
			</div>
		</a>
		<br />
		<span class="cir_title"><?php echo $name; ?></span>
		<br />
		<span class="cir_desc"><?php echo $description; ?></span>
	</div>
	<?php
}
?>