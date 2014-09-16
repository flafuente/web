<?php defined('_EXE') or die('Restricted access'); ?>

<div class='title-line'>
    <span>HISTÓRICO DE NOTICIAS</span>
</div>
<div class="filtro_news">
    <form action="<?=Url::site("tribonews/historico");?>" method="POST">
        <div class="col-md-2 titfil">
            Filtrar por:
        </div>
        <div style="clear: both;"></div>
        <div class="col-md-4 btn btnfiltro">
            <div class="filter">
                Categoría<br />
                <?=HTML::select("categoriaId", $categorias, $_REQUEST["categoriaId"], array("class" => "change-submit"), array("display" => "Selecciona una categoría"), array("display" => "nombre")); ?>
            </div>
        </div>
        <div class="col-md-4 btn btnfiltro">
            <div class="filter">
                Zona<br />
                <?=HTML::select("comunidadId", $comunidades, $_REQUEST["comunidadId"], array("class" => "change-submit"), array("display" => "Selecciona una comunidad"), array("display" => "nombre")); ?>
            </div>
        </div>
        <div class="col-md-4 btn btnfiltro">
            <div class="filter">
                Fecha<br />
                <input type="text" name="fecha" id="datepicker" class="change-submit" value="<?=Helper::sanitize($_REQUEST["fecha"])?>"/>
            </div>
        </div>
        <div style="clear: both;"></div>
        <!-- Videos -->
        <?php if (count($videos)) { ?>
            <?php foreach ($videos as $video) { ?>
                <?php $controller->setData("video", $video); ?>
                <?=$controller->view("modules.video-mini");?>
            <?php } ?>
        <?php } else { ?>
            <blockquote>
                No se han encontrado notícias
            </blockquote>
        <?php } ?>

        <div style="clear: both;"></div>

        <!-- Paginación -->
        <?php $controller->setData("pag", $pag); ?>
        <?=$controller->view("modules.pagination");?>

    </form>
</div>

<div style="clear: both;"></div>
