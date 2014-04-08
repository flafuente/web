<?php defined('_EXE') or die('Restricted access'); ?>
<div class="contenido">
	<div class="si_map col-md-5">
		<h1>MAPA DE COBERTURA</h1>
		<div class="percent col-md-4 counter_cont"><span class="perc" id="count-act">85</span><span class="perc">%</span><br />TERRITORIO ESPAÑOL</div>
		<img src="<?=Url::template("/img/sintonizanos/mapa.png");?>" />
	</div>
	<div class="si_donde col-md-4">
		<img src="<?=Url::template("/img/sintonizanos/sintoniza.png");?>" />
		<div>Desde ahora <strong>TRIBO TV</strong> se sintoniza en <strong>Multiplex mp3</strong> o <strong>Mux 39</strong> en la frecuencia entre los parámetros 685 y 796 Mhz.</div>
	</div>
	<div class="si_comenta col-md-3">
		<!--<form id="search">
			<input type="text" class="col-md-9" placeholder="Buscar en la web... " />
			<button class="col-md-3"><i class="fa fa-search" style="margin-left: -6px;"></i></button>
		</form>
		<br /><br />-->
		Comenta <strong>tribo</strong>
		<img src="<?=Url::template("/img/sintonizanos/comenta.png");?>" />
	</div>

	<div style="clear: both;"></div>
</div>
<div class="contenido">
	<div class="si_down col-md-8">
		<img src="<?=Url::template("/img/sintonizanos/downimg.png");?>" />
		<div class="texto">Aenean ac orci non erat vestibulum elementum vitae cursus felis. Mauris iaculis rhoncus mi, ut porta libero posuere sit amet. Phasellus fringilla ante orci, non imperdiet metus venenatis ullamcorper. Aliquam tincidunt elit ipsum, in euismod eros aliquam et.</div>
	</div>
	<div class="si_down col-md-4" style="float: right;">
		<?=$controller->view("modules.publiIns");?>
	</div>
</div>
<script type="text/javascript" src="<?=Url::template("/js/jquery.countTo.js");?>"></script>
<script>
	$("#count-act").countTo({
		from: 0,
		to: 85,
		speed: 1500
	});
</script>