<?php defined('_EXE') or die('Restricted access'); ?>
<?php

?>
<div class='title-line'>
<span>TRIBERS</span>
</div>
<br /><br />
<div class="col-md-1"></div>
<?php
showCircle("trib01.jpg", "triber01");
showCircle("trib02.jpg", "triber02");
showCircle("trib03.jpg", "triber03");
showCircle("trib04.jpg", "triber04");
showCircle("trib05.jpg", "triber05");
?>
<div class="col-md-1"></div>
<?php



function showCircle($icon, $url, $name = "", $description = ""){
	?>
	<div class="col-md-2 circle_items">
		<a href="<?=Url::site("triber/".$url); ?>">
			<div class="l_circle" style="background-image: url('<?=Url::template("img/tribers/".$icon); ?>');">
			</div>
		</a>
		<!--
		<br />
		<span class="cir_title"><?php echo $name; ?></span>
		<br />
		<span class="cir_desc"><?php echo $description; ?></span>
		-->
	</div>
	<?php
}
?>