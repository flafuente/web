<?php defined('_EXE') or die('Restricted access');

seeSquare("sq_deportes.jpg", "DEPORTES", "deportes", rand(10, 999));
seeSquare("sq_moda.jpg", "MODA", "moda", rand(10, 999));
seeSquare("sq_cocina.jpg", "COCINA", "cocina", rand(10, 999));
seeSquare("sq_musica.jpg", "MUSICA", "musica", rand(10, 999));

function seeSquare($img, $title, $url, $num){
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
				<?php echo $num; ?>
				<i class="fa fa-heart-o"></i>
			</div>
		</div>
	</div>
	<?php
}
?>