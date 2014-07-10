<?php defined('_EXE') or die('Restricted access'); ?>
<div class='title-line'>
    <span>ÚLTIMAS NOTICIAS</span>
</div>

<?php

seeProgram("not01.jpg", "INUNDACIONES EN CUENCA", "periodismociudadano/inundaciones");
seeProgram("not01.jpg", "MANIFESTACIÓN DE MARCHAS ANTIGLOBALIZACIÓN", "periodismociudadano/manifestaciones");
seeProgram("not01.jpg", "PROCLAMACIÓN FELIPE VI", "periodismociudadano/proclamacion");
seeProgram("not01.jpg", "PROTESTAS REPUBLICANAS", "periodismociudadano/protestas");

?>
<div class="col-md-offset-6 col-md-6 ver-todas-web">
    Ver histórico de noticias&nbsp;&nbsp;<div class="circulo-azul">+</div>
</div>

<div style="clear: both;"></div>

<?php
function seeProgram($img, $title, $url)
{
    ?>
    <div class='col-md-6 square'>
        <img src="<?=Url::template("img/noticias/".$img)?>" title="<?php echo $title; ?>" />
        <img class="arrow" src="<?=Url::template("img/arrow.png")?>" />
        <div class="sq_content">
            <div class="sq_title">
                <a href="<?=Url::site($url);?>">
                <?php echo $title; ?>
                </a>
            </div>
        </div>
    </div>
    <?php
}
