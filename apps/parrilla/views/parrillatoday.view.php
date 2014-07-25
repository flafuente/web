<?php
if(isset($_POST["fecha"]) && strlen($_POST["fecha"])>0){
	/*Sacar la parrilla del dia predeterminado*/
	showParrilla(date("Y-m-d", strtotime($_POST["fecha"])));
}else{
	/*Sacar la parrilla de HOY*/
	showParrilla(date("Y-m-d"));
}


function showParrilla($fecha){
	/*Sacar de BBDD los eventos de ese dia*/
	for($x=0; $x<23; $x++){
		showShow(($x+1).":00", "kalico.jpg", "Titulo Serie", "Sacado del dia ".$fecha);
	}
}

function showShow($hora, $image, $titulo, $descripcion){
	?>
	<div class="parrilla_elemento">
		<div class="col-md-2 parr_hora"><?=$hora;?></div>
		<div class="col-md-5 parr_image"><img src="<?=Url::template("img/programas/".$image);?>" /></div>
		<div class="col-md-5 parr_info">
			<span class="parr_titulo"><?=$titulo;?></span>
			<br />
			<span class="parr_descripcion"><?=$descripcion;?></span>
		</div>
	</div>
	<?php
}
?>