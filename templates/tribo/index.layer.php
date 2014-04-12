<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>Tribo.tv</title>
		<!--css-->
		<!-- Bootstrap -->
		<link href="<?=Url::template("css/bootstrap.min.css");?>" media="screen" rel="stylesheet" type="text/css" />
		<!-- Custom CSS -->
		<link href="<?=Url::template("css/custom.css");?>" media="screen" rel="stylesheet" type="text/css" />
		<!-- Font Awensome CSS -->
		<link href="<?=Url::template("css/font-awesome.min.css");?>" media="screen" rel="stylesheet" type="text/css" />
		<!-- JQuery File Upload Plugin -->
		<link href="<?=Url::template("css/jquery.fileupload.css");?>" media="screen" rel="stylesheet" type="text/css" />
		<!-- Select2 Plugin -->
		<link href="<?=Url::template("css/select2.css");?>" media="screen" rel="stylesheet" type="text/css" />
		<link href="<?=Url::template("css/select2-bootstrap.css");?>" media="screen" rel="stylesheet" type="text/css" />
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	    <![endif]-->
	    <!--/css-->
	    <!--javascript-->
		<!-- JQuery -->
		<script src="<?=Url::template("js/jquery-1.11.0.min.js");?>" type="text/javascript"></script>
		<!-- Bootstrap -->
		<script src="<?=Url::template("js/bootstrap.min.js");?>" type="text/javascript"></script>
		<!-- JQuery Forms Plugin -->
		<script src="<?=Url::template("js/jquery.forms.js");?>" type="text/javascript"></script>
		<!-- Image Holder -->
		<script src="<?=Url::template("js/holder.js");?>" type="text/javascript"></script>
		<!-- JQuery JSSor -->
		<script src="<?=Url::template("js/jssor.core.js");?>" type="text/javascript"></script>
		<script src="<?=Url::template("js/jssor.utils.js");?>" type="text/javascript"></script>
		<script src="<?=Url::template("js/jssor.slider.js");?>" type="text/javascript"></script>
		<!-- Select2 Plugin -->
		<script src="<?=Url::template("js/select2.min.js");?>" type="text/javascript"></script>
		<script src="<?=Url::template("js/select2_locale_es.js");?>" type="text/javascript"></script>
		<!-- JQuery Upload -->
		<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
		<script src="<?=Url::template("js/jquery.ui.widget.js");?>" type="text/javascript"></script>
		<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
		<script src="<?=Url::template("js/jquery.iframe-transport.js");?>" type="text/javascript"></script>
		<!-- The basic File Upload plugin -->
		<script src="<?=Url::template("js/jquery.fileupload.js");?>" type="text/javascript"></script>
		<!-- Framework JS -->
		<script src="<?=Url::template("js/init.js");?>" type="text/javascript"></script>
		<!--/javascript-->
		<link rel="shortcut icon" href="<?=Url::template("img/favicon.png")?>">
	</head>
	<body class="">
		<!-- Module publiTop -->
		<?=$controller->view("modules.publiTop");?>
		<!--/Module publiTop-->

		<!-- Module topMenu -->
		<?=$controller->view("modules.topMenu");?>
		<!--/Module topMenu-->

		<!--mainContainer-->
		<div class="container main">

			<div class='row top hidden-xs'></div>

	        <!-- Module publiLat -->
	        <?=$controller->view("modules.publiLat");?>
	        <!--/Module publiLat-->

			<div class='col-md-8'>

				<!--alerts-->
				<?php $messages = Registry::getMessages(); ?>
				<div id="mensajes-sys">
				<?php if($messages){ ?>
					<?php foreach($messages as $message){ ?>
						<?php if($message->message){ ?>
							<div class="alert alert-<?=$message->type?>">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								<?=$message->message?>
							</div>
						<?php } ?>
					<?php } ?>
				<?php } ?>
				</div>
				<!--/alerts-->

				<!--content-->
				<?=$content?>
				<!--/content-->

				<div class="col-md-12 footer">
					tribotv©2014
				</div>

	        </div>
	        <!-- Module publiLat -->
	        <?=$controller->view("modules.publiLat");?>
	        <!--/Module publiLat-->

	    </div>
		<!--/mainContainer-->

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