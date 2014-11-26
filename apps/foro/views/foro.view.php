<?php defined('_EXE') or die('Restricted access'); ?>

<?php
$seccionEjmplo = new stdClass();
$seccionEjmplo->icono = Url::template("img/weirdicon.png");
$seccionEjmplo->titulo = "Funcionamiento del foro";
$seccionEjmplo->descripcion = "Normas de utilización del Foro triber";
$seccionEjmplo->thumb = $user->getFotoUrl();
$seccionEjmplo->lastpost = "Ultimo post";
$seccionEjmplo->lastpost_desc = "hace x tiempo por ".$user->username;
$seccionEjmplo->ntemas = rand(5, 500);
$seccionEjmplo->nactua = rand(1, 10);
?>

<div class='title-line title-line-left'>
    <span>FORO TRIBER</span>
</div>
<div class='col-md-12'>
    <div class="square-info-foro">
        <div class="grey" style="margin-bottom: 0px;">
            INFORMACIÓN GENERAL
        </div>
    </div>
    <?php
    $secciones = array($seccionEjmplo, $seccionEjmplo, $seccionEjmplo, $seccionEjmplo);
    foreach($secciones as $seccion){
        $controller->setData("seccion", $seccion);
        echo $controller->view("modules.seccion");
    }
    ?>
    
</div>
<div class="clear: both;"></div>
<div class='col-md-12'>
    <div class="square-info-foro">
        <div class="grey" style="margin-bottom: 0px;">
            PERIODISMO CIUDADANO
        </div>
    </div>
    <?php
    foreach($secciones as $seccion){
        $controller->setData("seccion", $seccion);
        echo $controller->view("modules.seccion");
    }

    ?>
    
</div>
<div class="clear: both;"></div>
<div class='col-md-12'>
    <div class="square-info-foro">
        <div class="grey" style="margin-bottom: 0px;">
            TRIBO INVESTIGACIÓN
        </div>
    </div>
    <?php
    foreach($secciones as $seccion){
        $controller->setData("seccion", $seccion);
        echo $controller->view("modules.seccion");
    }
    ?>
    
</div>
<div class="clear: both;"></div>
<div class='col-md-12'>
    <div class="square-info-foro">
        <div class="grey" style="margin-bottom: 0px;">
            OTROS
        </div>
    </div>
    <?php
    foreach($secciones as $seccion){
        $controller->setData("seccion", $seccion);
        echo $controller->view("modules.seccion");
    }
    ?>
    
</div>