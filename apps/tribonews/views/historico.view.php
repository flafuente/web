<?php defined('_EXE') or die('Restricted access'); ?>

<div class='title-line'>
    <span>HISTÓRICO DE NOTICIAS</span>
</div>
<div class="filtro_news">
    <form action="<?=Url::site("tribonews/historico");?>" method="POST">
        <div class="col-md-2 titfil">
            Filtrar por:
        </div>
        <div class="col-md-3">
            <div class="filter">
                Categoría
                <?=HTML::select("categoriaId", $categorias, $_REQUEST["categoriaId"], array("class" => "change-submit"), array("display" => "Selecciona una categoría"), array("display" => "nombre")); ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="filter">
                Zona
                <select name="fil_zona" class="select2 change-submit">
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
                <input type="text" name="fil_fecha" id="datepicker" class="change-submit" value="<?=Helper::sanitize($_REQUEST["fil_fecha"])?>"/>
            </div>
        </div>
    </form>
</div>
<div style="clear: both;"></div>

<!-- Videos -->
<?php foreach ($videos as $video) { ?>
    <?php $controller->setData("video", $video); ?>
    <?=$controller->view("modules.video-mini");?>
<?php } ?>

<div style="clear: both;"></div>
