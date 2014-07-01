<?php defined('_EXE') or die('Restricted access');

?>

<div class='col-md-12 serie_info'>
	<div class="serie_title">
		PRINCESA ROTA
	</div>
	<div class="serie_when">
		MIERCOLES 22:00
	</div>
	<br />
	<div class="serie_description">
		Isabel lleva ocho meses bajo atención hospitalaria. Varias cicatrices salpican su joven cuerpo, pero una amnesia, producida por un complejo traumatismo, le impide conocer la naturaleza de sus heridas. Ni siquiera su nombre es Isabel, esa identidad ha sido creada por su médico para ayudarla en la formación de su personalidad ya que nadie parece saber nada sobre ella.
		<br /><br />
		En la tranquilidad de la sala de rehabilitación, mientras hace sus ejercicios diarios y bajo la supervisión de su enfermera y única amiga, Blanca, recibe la noticia de la que va a ser, su último reconocimiento médico. El doctor Lavigne, neurocirujano que atendió a Isabel desde su ingreso, le anuncia que los progresos son satisfactorios y debe darle el alta.
	</div>
	<div style="clear: both;"></div>
	<div class='col-md-offset-6 col-md-6 epi_button'>
		<a href="<?=Url::site("programa/n_programa");?>">site programa</a> <strong>|</strong> <a href="<?=Url::site("capitulos/n_programa");?>">todos los capitulos</a>
	</div>
</div>

<?php


for($x=19; $x>15; $x--){
	seeEpisode("sq_musica.jpg", 
			   "EN LA TRANQUILIDAD", 
			   "episodios/princesa_rota", 
			   rand(100, 9999), 
			   "Isabel lleva ocho meses bajo atención hospitalaria. Varias cicatrices salpican su joven cuerpo, pero una amnesia, producida por un complejo traumatismo, le impide conocer la naturaleza de sus heridas.",
			   "40:0".rand(0, 9),
			   "CAPÍTULO ".$x);
}

function seeEpisode($img, $title, $url, $likes, $description, $duration, $name){
	?>
	<div class='col-md-6 square'>
		<img src="<?=Url::template("img/".$img)?>" title="<?php echo $title; ?>" />
		<div class="sq_content">
			<div class="sq_title">
				<a href="<?=Url::site($url);?>">
				<?php echo $title; ?>
				</a>
			</div>
			<div class="sq_num">
				<?php echo $likes; ?>
				<i class="fa fa-heart-o"></i>
			</div>
		</div>
	</div>
	<div class='col-md-6 squaredesc'>
		<a  class="sqd_title" href="<?=Url::site($url);?>">
			<?php echo $title; ?>
		</a>
		<br /><br />
		<div class="sqd_description"><?php echo $description; ?></div>
		<span class="sqd_info"><?php echo $duration; ?> | <?php echo $name; ?></span>
	</div>
	<div style="clear: both;"></div>
	<?php
}
?>