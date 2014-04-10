<!DOCTYPE html>
<html style='height:100%;' lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>Tribo.tv - la nueva TV</title>
		<!-- Bootstrap core CSS -->
		<link href="<?=Url::template("css/bootstrap.min.css");?>" rel="stylesheet">
		<link href="<?=Url::template("css/landing.css");?>" rel="stylesheet">
		  <!-- Chang URLs to wherever Video.js files will be hosted -->
		<link href="<?=Url::template("js/video-js/video-js.css");?>" rel="stylesheet" type="text/css">
		<!-- video.js must be in the <head> for older IEs to work. -->
		<script src="<?=Url::template("js/video-js/video.js");?>"></script>

		<!-- Unless using the CDN hosted version, update the URL to the Flash SWF -->
		<script>
			videojs.options.flash.swf = "<?=Url::template("js/video-js/video-js.swf");?>";
		</script>
	</head> 
	<body style='height:100%;'> 
	<div class='hidden-xs publi'>
	publicidad
	</div>
	<div class='bg'>
		<div class='img'><img src='<?=Url::template("img/logo.png")?>' /></div>
		<div class=' vdivider hidden-xs'></div>
		<div class='container' > 
			<div class='vplayer'>
				<video id="example_video_1" class="video-js vjs-default-skin" controls preload="none" width="auto" height="242"
				data-setup="{}">
	    <source src="http://video-js.zencoder.com/oceans-clip.mp4" type='video/mp4' />
	    <source src="http://video-js.zencoder.com/oceans-clip.webm" type='video/webm' />
	    <source src="http://video-js.zencoder.com/oceans-clip.ogv" type='video/ogg' />
				</video>
			</div>
		</div>
		<div class='fr'>
			<a href='<?=Url::site("home/inicio");?>'><div class='izq'></div><div class='mid'>ENTRAR</div><div class='dcha'></div></a>
		</div>
		<?=$controller->view("modules.social");?>
	</div>
	<!-- Debugging Modals -->
    <?php $config = Registry::getConfig(); ?>
    <?php if($config->get("debug")){ ?>
        <?php $debug = Registry::getDebug(); ?>
        <!-- Current Queries Debug Modal -->
        <?php $controller->setData("debug", $debug); ?>
        <?php $controller->setData("debugModalId", "Current"); ?>
        <?=$controller->view("modules.debugModalQueries");?>
        <!-- Previous Queries Debug Modal -->
        <?php if($_SESSION['debug']['queries']){ ?>
            <?php $controller->setData("debug", $_SESSION['debug']); ?>
            <?php $controller->setData("debugModalId", "Last"); ?>
            <?=$controller->view("modules.debugModalQueries");?>
        <?php } ?>
        <!-- Session Debug Modal -->
        <?=$controller->view("modules.debugModalSession");?>
        <!-- Current Messages Debug Modal -->
        <?php $controller->setData("debug", $debug); ?>
        <?php $controller->setData("debugModalId", "Current"); ?>
        <?=$controller->view("modules.debugModalMessages");?>
        <!-- Ajax Messages Debug Modal -->
        <?php $controller->setData("debugModalId", "Ajax"); ?>
        <?=$controller->view("modules.debugModalMessages");?>
    <?php } ?>
    <!-- /Debugging Modals -->
	<?php if($config->get("debug")){ ?>
		<!-- Footer -->
		<footer class="footerDebug">
            <!-- Debugging Menu -->
            <?php $controller->setData("debug", $debug); ?>
            <?=$controller->view("modules.debugMenu");?>
            <!-- /Debugging Menu -->
    	</footer>
    	<!-- /Footer -->
	<?php } ?>
	</body>
</html>