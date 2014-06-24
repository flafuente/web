<?php defined('_EXE') or die('Restricted access'); ?>
<div class='col-md-12'>
	<ul class="nav nav-pills nav-stacked">
	  <!--  class="active" -->
	 	<?php $url = Registry::getUrl(); ?>
		<?php $active = array(); ?>
		<?php $active[$url->app][$url->action] = "active"; ?>

	  <li class="<?=$active["programas"];?>"><a href="<?=Url::site("programas");?>">PROGRAMAS</a></li>
	  <li class="<?=$active["informativos"];?>"><a href="<?=Url::site("informativos");?>">INFORMATIVOS</a></li>
	  <li class="<?=$active["tv-directo"];?>"><a href="<?=Url::site("tv-directo");?>">TV EN DIRECTO</a></li>
	  <li class="<?=$active["tu-haces-tribo"];?>"><a href="<?=Url::site("tu-haces-tribo");?>">TÚ HACES TRIBO</a></li>
	</ul>
</div>

<!-- PARRILLA -->
<div class='col-md-12'>
	<div class="parrilla">
		<div class="parrilla-cabecera">
			<h1>AHORA EN<br />TRIBO</h1>
			<h2>Ver la Parrilla&nbsp;&nbsp;+</h2>
		</div>
		<?php
		for($x=0; $x<3; $x++){
			if($x == 2) $cls = ""; else $cls = "line";
			$hora = rand(1440, 86400);
			?>
			<div class="parrilla-contenido <?php echo $cls; ?>">
				<span class="hora"><?php echo date("H:i", $hora); ?></span>
				<span class="titulo">TITULO <?php echo ($x+1); ?></span>
			</div>
			<?php
		}
		?>
	</div>
</div>

<!-- Sintonizanos -->
<div class='col-md-12'>
	SINTONIZANOS
</div>
