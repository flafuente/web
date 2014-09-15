<?php defined('_EXE') or die('Restricted access'); ?>

<?php
$temaEjemplo = new stdClass();
$temaEjemplo->icono = Url::template("img/weirdicon.png");
$temaEjemplo->titulo = "Funcionamiento del foro";
$temaEjemplo->descripcion = "Normas de utilización del Foro triber";
$temaEjemplo->thumb = $user->getFotoUrl();
$temaEjemplo->lastpost = "Ultimo post";
$temaEjemplo->lastpost_desc = "hace x tiempo por ".$user->username;
$temaEjemplo->ntemas = rand(5, 500);
$temaEjemplo->nactua = rand(1, 10);
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
    $temas = array($temaEjemplo, $temaEjemplo, $temaEjemplo, $temaEjemplo);
    foreach($temas as $tema){
        $controller->setData("tema", $tema);
        echo $controller->view("modules.tema");
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
    foreach($temas as $tema){
        $controller->setData("tema", $tema);
        echo $controller->view("modules.tema");
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
    foreach($temas as $tema){
        $controller->setData("tema", $tema);
        echo $controller->view("modules.tema");
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
    foreach($temas as $tema){
        $controller->setData("tema", $tema);
        echo $controller->view("modules.tema");
    }
    ?>
    
</div>