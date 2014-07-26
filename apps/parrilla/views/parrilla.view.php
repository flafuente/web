<?php defined('_EXE') or die('Restricted access');?>
<div class='title-line'>
    <span>Parrilla Completa</span>
</div>
<div class="row">
	<div class="fechas">
	<?php
	$dias = Array("1" => "Lunes",
				  "2" => "Martes",
				  "3" => "Miercoles",
				  "4" => "Jueves",
				  "5" => "Viernes",
				  "6" => "Sabado",
				  "7" => "Domingo");
	$meses = Array("1" => "Enero",
				  "2" => "Febrero",
				  "3" => "Marzo",
				  "4" => "Abril",
				  "5" => "Mayo",
				  "6" => "Junio",
				  "7" => "Julio",
				  "8" => "Agosto",
				  "9" => "Septiembre",
				  "10" => "Octubre",
				  "11" => "Noviembre",
				  "12" => "Diciembre");
	$hoy = strtotime(date("Y-m-d"));
	for($x=0; $x<7; $x++){
		$diaSuma = $x*(60*60*24);
		?>
		<div class="seldateparr" fecha-parrilla="<?=date("Y-m-d", $hoy+$diaSuma);?>">
			<span class="p_dia"><?=$dias[date("N", $hoy+$diaSuma)]; ?></span>
			<br />
			<span class="p_mes"><?=date("d", $hoy+$diaSuma); ?> de <?=$meses[date("n", $hoy+$diaSuma)]; ?></span>
		</div>
		<?php
	}

	?>
	</div>
	<div style="clear: both;"></div>
	<div class="parrilla_big" id="parr_content">
	</div>
	<div id="loading"></div>
</div>

<script>
	$( document ).ready(function() {
        $("#loading").css("display", "initial");
        $.ajax({
            type: "POST",
        	url: "<?=Url::site('parrilla/today/');?>",
        	dataType: "json"
        }).done(function (data) {
            $("#parr_content").html(data["data"]["html"]);
            $("#loading").css("display", "none");
        });
        return false;
	});
	$(document).on("click",".seldateparr",function(){
        fecha=$(this).attr("fecha-parrilla");
        $("#loading").css("display", "initial");
        $.ajax({
            type: "POST",
            data: {fecha: fecha},
        	url: "<?=Url::site('parrilla/today/');?>",
        	dataType: "json"
        }).done(function (data) {
            $("#parr_content").html(data["data"]["html"]);
            $("#loading").css("display", "none");
        });
        return false;
    });

</script>