<?php defined('_EXE') or die('Restricted access'); ?>
<div class='title-line'>
    <span>HISTÓRICO DE NOTICIAS</span>
</div>
<div class="filtro_news">
    <div class="col-md-2 titfil">
        Filtrar por:
    </div>
    <div class="col-md-3">
        <div class="filter">
            Seccion
            <select name="fil_seccion">
                <option value="1">Seccion 01</option>
                <option value="2">Seccion 02</option>
                <option value="3">Seccion 03</option>
                <option value="4">Seccion 04</option>
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="filter">
            Zona
            <select name="fil_zona" class="select2">
                <option value="1">Zona 01</option>
                <option value="2">Zona 02</option>
                <option value="3">Zona 03</option>
                <option value="4">Zona 04</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="filter">
            Fecha
            <input type="text" name="fil_fecha" id="datepicker" />
        </div>
    </div>
</div>
<div style="clear: both;"></div>
<?php

seeProgram("not01.jpg", "INUNDACIONES EN CUENCA", "periodismociudadano/inundaciones");
seeProgram("not01.jpg", "MANIFESTACIÓN DE MARCHAS ANTIGLOBALIZACIÓN", "periodismociudadano/manifestaciones");
seeProgram("not01.jpg", "PROCLAMACIÓN FELIPE VI", "periodismociudadano/proclamacion");
seeProgram("not01.jpg", "PROTESTAS REPUBLICANAS", "periodismociudadano/protestas");
seeProgram("not01.jpg", "PROCLAMACIÓN FELIPE VI", "periodismociudadano/proclamacion");
seeProgram("not01.jpg", "PROTESTAS REPUBLICANAS", "periodismociudadano/protestas");
seeProgram("not01.jpg", "PROCLAMACIÓN FELIPE VI", "periodismociudadano/proclamacion");
seeProgram("not01.jpg", "PROTESTAS REPUBLICANAS", "periodismociudadano/protestas");

?>

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
