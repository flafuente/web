<?php defined('_EXE') or die('Restricted access'); ?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Tribo.tv</title>
    <link rel="shortcut icon" href="<?=Url::template("img/favicon.png");?>" type="image/png" />

    <!--css-->
    <!-- Font -->
    <?php Minify::css("css/font.css"); ?>
    <!-- JQuery UI -->
    <?php Minify::css("css/jquery-ui.css"); ?>
    <!-- Bootstrap -->
    <?php Minify::css("css/bootstrap.css"); ?>
    <!-- Font Awensome CSS -->
    <?php Minify::css("css/font-awesome.css"); ?>
    <!-- JQuery File Upload Plugin -->
    <?php Minify::css("css/jquery.fileupload.css"); ?>
    <!-- Select2 Plugin -->
    <?php Minify::css("css/select2.css"); ?>
    <?php Minify::css("css/select2-bootstrap.css"); ?>
    <!-- Scrollbar -->
    <?php Minify::css("css/jquery.mCustomScrollbar.css"); ?>
    <!-- Custom CSS -->
    <?php Minify::css("css/custom.css"); ?>

    <?php Minify::renderCss(); ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <!--/css-->

    <!--javascript-->
    <!-- JQuery -->
    <?php Minify::js("js/jquery-1.11.0.min.js"); ?>
    <!-- JQuery UI -->
    <?php Minify::js("js/jquery-ui.js"); ?>
    <!-- Bootstrap -->
    <?php Minify::js("js/bootstrap.min.js"); ?>
    <!-- Bootstrap File Input Plugin -->
    <?php Minify::js("js/bootstrap.file-input.js"); ?>
    <!-- JQuery Forms Plugin -->
    <?php Minify::js("js/jquery.forms.js"); ?>
    <!-- Image Holder -->
    <?php Minify::js("js/holder.js"); ?>
    <!-- JQuery JSSor -->
    <?php Minify::js("js/jssor.core.js"); ?>
    <?php Minify::js("js/jssor.utils.js"); ?>
    <?php Minify::js("js/jssor.slider.js"); ?>
    <!-- Select2 Plugin -->
    <?php Minify::js("js/select2.min.js"); ?>
    <?php Minify::js("js/select2_locale_es.js"); ?>
    <!-- JQuery Place Picker -->
    <?php Minify::js("js/jquery.placepicker.js"); ?>
    <!-- JQuery Upload -->
    <?php Minify::js("js/jquery.fileupload.js"); ?>
    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <?php Minify::js("js/jquery.iframe-transport.js"); ?>
    <!-- Custom scrollbar -->
    <?php Minify::js("js/jquery.mCustomScrollbar.concat.min.js"); ?>
    <!-- Framework JS -->
    <?php Minify::js("js/init.js"); ?>

    <?php Minify::renderJs(); ?>

    <!-- Wistia -->
    <script charset="ISO-8859-1" src="//fast.wistia.com/assets/external/E-v1.js"></script>

    <!--/javascript-->

</head>
