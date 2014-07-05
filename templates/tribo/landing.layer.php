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
        <!-- Bootstrap File Input Plugin -->
        <script src="<?=Url::template("js/bootstrap.file-input.js");?>" type="text/javascript"></script>
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
    <body class="body">
        <div class="mask" style="display: none;"></div>
        <!-- Module topMenu -->
        <?=$controller->view("modules.topMenu");?>
        <!--/Module topMenu-->

        <!--mainContainer-->
        <div class="container main">

            <?=$controller->view("modules.homeSlider");?>

            <div class='col-md-2 nopadding' style="padding-right: 5px;">
                <?=$controller->view("modules.mainMenu");?>
            </div>
            <div class='col-md-10 nopadding bor_lef'>
                <div class='col-md-9 nopadding'>
                    <?php
                    seeSquare("sq_deportes.jpg", "DEPORTES", "deportes", rand(10, 999));
                    seeSquare("sq_moda.jpg", "MODA", "moda", rand(10, 999));
                    seeSquare("sq_cocina.jpg", "COCINA", "cocina", rand(10, 999));
                    seeSquare("sq_musica.jpg", "MUSICA", "musica", rand(10, 999));
                    ?>
                </div>
                <div class='col-md-3 nopadding'>
                    <?=$controller->view("modules.twitter");?>
                </div>
                <div class="separador"></div>
                <div class='col-md-12 nopadding'>
                    <?=$controller->view("modules.bottomButtons");?>
                </div>
            </div>
        </div>
        <?=$controller->view("modules.Footer");?>
        <!--/mainContainer-->

        <!-- Debug -->
        <?=$controller->view("modules.debug.menu");?>
        <!-- /Debug -->
    </body>
</html>

<?php
function seeSquare($img, $title, $url, $likes)
{
    ?>
    <div class='col-md-6 square'>
        <img src="<?=Url::template("img/".$img)?>" title="<?php echo $title; ?>" />
        <img class="arrow" src="<?=Url::template("img/arrow.png")?>" />
        <div class="rating"><?=HTML::showRate($likes, 999, 10);?></div>
        <div class="sq_content">
            <div class="sq_title">
                <a href="<?=Url::site($url);?>">
                <?php echo $title; ?>
                </a>
            </div>
            <div class="sq_num">
                <?php echo $likes; ?>
                <i class="fa fa-heart-o"></i>
            </div>
        </div>
    </div>
    <?php
}
?>
