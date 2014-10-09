<?php defined('_EXE') or die('Restricted access'); ?>

<?php
/*
$nota = new stdClass();
$nota->imagen = Url::template("img/cosmotrip.png");
$nota->titulo = "TRIBO TV YA SE PUEDE VER EN TODAS LAS COMUNIDADES AUTÓNOMAS";
$nota->descripcion = "Este octubre comienza una nueva historia, la aventura de las mil y una caras, las caras de Tribo, la televisión de todos hecha ";
$nota->nota = "kjfds kdsafh kjfdt gdfgsdifsdt fdsygdfsyfdgdfstibk";
$nota->adjunto = "URL_Al_archivo.pdf";
$nota->fecha = date("d / m / Y");
*/
?>
<div class='col-md-12'>
    <div class="square-info-foro">
        <div class="grey" style="margin-bottom: 0px;">
            SALA DE PRENSA > NOTA DE PRENSA
        </div>
    </div>
    <div class="nota_prensa">
        <div class="nota_header">
            <div class="col-md-4 nopaddingI">
                <img src="<?=Helper::sanitize($nota->imagen); ?>" />
            </div>
            <div class="col-md-8">
                <h2><?= $nota->fecha; ?></h2>
                <h1><?= $nota->titulo; ?></h1>
                <h3><?= $nota->descripcion; ?></h3>
            </div>
        </div>
        <div style="clear: both;"></div>
        <hr />
        <div class="nota_content">
            <?php
            echo $nota->nota;
            if($nota->adjunto != ""){
                ?>
                <br /><br />
                <img src="<?=Url::template("img/pdficon.png");?>" /><a href="<?=$nota->adjunto;?>">Descargar esta nota en PDF</a>
                <?php
            }
            ?>
        </div>
    </div>
    
</div>