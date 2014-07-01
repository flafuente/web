<?php defined('_EXE') or die('Restricted access');

?>

<div class='title-line'>
<span>WEB SERIES</span>
</div>

<?php

seeProgram("princesa_rota.jpg", "MIÉRCOLES 22:00", "episodios/princesa_rota");
seeProgram("besitos.jpg", "LUNES 22:00", "episodios/besitos");
seeProgram("kalico.jpg", "JUEVES 22:00", "episodios/kalico");
seeProgram("malviviendo.jpg", "VIERNES 22:00", "episodios/malviviendo");
seeProgram("libres.jpg", "MARTES 22:00", "episodios/libres");
seeProgram("libres.jpg", "MARTES 22:00", "episodios/libres");


?>
<div class="col-md-offset-6 col-md-6 ver-todas-web">
	Ver todas las Webseries&nbsp;&nbsp;<div class="circulo-azul">+</div>
</div>
<?php

function seeProgram($img, $title, $url){
	?>
	<div class='col-md-6 square'>
		<img src="<?=Url::template("img/programas/".$img)?>" title="<?php echo $title; ?>" />
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
?>