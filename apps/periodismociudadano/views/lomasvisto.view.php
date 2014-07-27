<?php defined('_EXE') or die('Restricted access');

?>

<div class="lomasvisto">
	<div class='title-line'>
		<span>LO MÁS VISTO ESTA SEMANA</span>
	</div>
	<div class="slider center">
		<?php
		for($x=0; $x<20; $x++){
			showMasVisto("TITULO", "not01.jpg", "Ciudad", rand(0,99999), "Autor", date("Y-m-d H:i:s"));
		}
		?>
	</div>
	<div style="clear: both;"></div>
</div>

<?php
function showMasVisto($titulo, $img, $donde, $reproducciones, $autor, $fecha){
	?>
	<div class='col-md-12'>
		<div class="mv-sqare">
			<div class="cropimg">
				<img src="<?=Url::template("img/noticias/".$img)?>" title="<?php echo $title; ?>" />
			</div>
			<div class='col-md-12 nopadding'><div class="mv-titulo"><?= $titulo; ?></div></div>
			<div class='col-md-12 nopadding'><div class="mv-donde"><?= $donde; ?></div><div class="mv-reproducciones"> | <?= number_format($reproducciones, 0, ",", "."); ?> reproducciones</div></div>
			<div class='col-md-12 nopadding'><div class="mv-autor"><span>por</span> <?= $autor; ?></div><div class="mv-fecha"> | <?= date("d/m/Y", strtotime($fecha)); ?> <span>a las</span> <?= date("H:i", strtotime($fecha)); ?></div></div>
			<div style="clear: both;"></div>
		</div>
	</div>
	<?php
}
?>
<link rel="stylesheet" type="text/css" href="<?=Url::template("css/slick.css");?>"/>
<script type="text/javascript" src="<?=Url::template("js/slick.min.js");?>"></script>
<script>
	$( document ).ready(function() {
        $('.center').slick({
		  arrows: true,
		  centerMode: true,
		  vertical: true,
		  centerPadding: '60px',
		  slidesToShow: 4,
		  responsive: [
		    {
		      breakpoint: 768,
		      settings: {
		        arrows: true,
		        centerMode: true,
		        centerPadding: '40px',
		        slidesToShow: 3
		      }
		    },
		    {
		      breakpoint: 480,
		      settings: {
		        arrows: true,
		        centerMode: true,
		        centerPadding: '40px',
		        slidesToShow: 1
		      }
		    }
		  ]
		});
	});
</script>