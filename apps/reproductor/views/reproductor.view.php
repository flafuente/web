<?php defined('_EXE') or die('Restricted access');

?>
<div class='col-md-12 serie_info'>
	<div class="col-md-12 video">
	</div>
	<div class="video-info">
		<div class="col-md-12 vd-ruta">Princesa rota / Capítulos</div>
		<div class="col-md-8">
			<div class="vd-codigo">C-0117 | </div><div class="vd-capitulo">EN LA TRANQUILIDAD</div>
		</div>
		<div class="col-md-4">
			<div class="sq_num">568 <i class="fa fa-heart-o"></i>
			</div>
		</div>
		<div class="col-md-12">
			<div class="vd-attr">40:03 | 24/06/2014 | </div><div class="vd-temporada">TEMPORADA 1</div>
		</div>
		<div class="col-md-12 video-desc">
		Isabel lleva ocho meses bajo atención hospitalaria. Varias cicatrices salpican su joven cuerpo, pero una amnesia, producida por un complejo traumatismo, le impide conocer la naturaleza de sus heridas. Ni siquiera su nombre es Isabel, esa identidad ha sido creada por su médico para ayudarla en la formación de su personalidad ya que nadie parece saber nada sobre ella.
		<br /><br />
		En la tranquilidad de la sala de rehabilitación, mientras hace sus ejercicios diarios y bajo la supervisión de su enfermera y única amiga, Blanca, recibe la noticia de la que va a ser, su último reconocimiento médico. El doctor Lavigne, neurocirujano que atendió a Isabel desde su ingreso, le anuncia que los progresos son satisfactorios y debe darle el alta.
		</div>
		<div style="clear: both;"></div>
	</div>

<?php
	for($x=7; $x>5; $x--){
	seeEpisode("sq_musica.jpg", 
			   "EN LA TRANQUILIDAD", 
			   "episodios/princesa_rota", 
			   rand(0, 1000), 
			   "Isabel lleva ocho meses bajo atención hospitalaria. Varias cicatrices salpican su joven cuerpo, pero una amnesia, producida por un complejo traumatismo, le impide conocer la naturaleza de sus heridas.",
			   "40:0".rand(0, 9),
			   "CAPÍTULO ".$x);
}
?>
	<div class='col-md-6 epi_button'>
		<a href="<?=Url::site("programas/n_programa");?>">site programa</a> <strong>|</strong> <a href="<?=Url::site("episodios/n_programa/all");?>">todos los capitulos</a>
	</div>
	<div class="col-md-6 ver-todas-web" style="margin-top: 30px;">
		Ver todas las Webseries&nbsp;&nbsp;<div class="circulo-azul">+</div>
	</div>
</div>
<?php
function seeEpisode($img, $title, $url, $likes, $description, $duration, $name){
	?>
	<div class='col-md-6 square'>
		<img src="<?=Url::template("img/".$img)?>" title="<?php echo $title; ?>" />
		<img class="arrow" src="<?=Url::template("img/arrow.png")?>" />
		<div class="rating"><?=HTML::showRate($likes, 1000);?></div>
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

