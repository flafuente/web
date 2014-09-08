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
                <?=HTML::select("comunidadId", $comunidades, $_REQUEST["comunidadId"], array("class" => "change-submit"), array("display" => "Selecciona una comunidad"), array("display" => "nombre")); ?>
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
<?php if (count($videos)) { ?>
    <?php foreach ($videos as $video) { ?>
        <?php $controller->setData("video", $video); ?>
        <?=$controller->view("modules.video-mini");?>
    <?php } ?>
<?php } ?>

<div style="clear: both;"></div>
