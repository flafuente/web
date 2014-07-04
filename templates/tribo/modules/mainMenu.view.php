<?php defined('_EXE') or die('Restricted access'); ?>
<div class='col-md-12' style='padding-left: 0px; padding-right: 0px;'>
	<ul class="nav nav-pills nav-stacked">
	  <!--  class="active" -->
	 	<?php $url = Registry::getUrl(); ?>
		<?php $active = array(); ?>
		<?php $active[$url->app][$url->action] = "active"; ?>

	  <li class="<?=$active["programas"]["index"];?> withsub">
	  	<a href="<?=Url::site("programas");?>">PROGRAMAS</a>
	  	<ul class="submenu" style="display: none;">
	  		<div class="triangle"></div>
	  		<?php
	  		for($x=0; $x<12; $x++){
	  			?><li class="col-md-6"><a href="<?=Url::site("programas/prog-".($x+1));?>"><?php echo "Elemento ".($x+1); ?></a></li><?php
	  		}
	  		?>
	  		
	  	</ul>
	  </li>
	  <li class="<?=$active["periodismociudadano"]["index"];?>">
	  	<a href="<?=Url::site("periodismociudadano");?>">PERIODISMO CIUDADANO</a>
	  </li>
	  <li class="<?=$active["tvdirecto"]["index"];?>">
	  	<a href="<?=Url::site("tvdirecto");?>">TV EN DIRECTO</a>
	  </li>
	  <li class="<?=$active["haztetriber"]["index"];?>"><a href="<?=Url::site("haztetriber");?>">HAZTE TRIBER</a></li>
	  <li class="<?=$active["quienessomos"]["index"];?>"><a href="<?=Url::site("quienessomos");?>">QUIÉNES SOMOS</a></li>
	</ul>
</div>

<!-- Scripts Menu -->
<script>
	$(document).on("mouseover",".withsub",function(){
        $(this).find('.submenu').css("display", "block");         
    });
    $(document).on("mouseout",".withsub",function(){
        $(this).find('.submenu').css("display", "none");         
    });
</script>

<!-- PARRILLA -->
<div class='col-md-12' style='padding-left: 0px; padding-right: 0px;'>
	<div class="parrilla">
		<div class="parrilla-cabecera">
			<h1>AHORA<br />EN TRIBO</h1>
			<h2>Ver la Parrilla&nbsp;&nbsp;<div class="circulo">+</div></h2>
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
<div class='col-md-12' style='padding-left: 0px; padding-right: 0px;'>
	<a href="<?=Url::site("sintonizanos");?>" class="btn sintonizanos"><img src="<?=Url::template("img/weirdicon.png")?>" />&nbsp;&nbsp;SINTONÍZANOS</a>
</div>
<div class='col-md-12' style='padding-left: 0px; padding-right: 0px;'>
	<a href="<?=Url::site("haztetriber");?>" class="btn sintonizanos betriber">be triber</a>
</div>
