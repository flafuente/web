<?php defined('_EXE') or die('Restricted access'); ?>

<div class='title-line'>
    <span>
        <?=Language::translate("VIEW_TRIBONEWS_TITLE");?>
    </span>
</div>
<div class="filtro_news">
    <form action="<?=Url::site("tribonews/historico");?>" method="POST">
        <div class="col-md-2 titfil">
            <?=Language::translate("VIEW_TRIBONEWS_FILTERS_TITLE");?>
        </div>
        <div style="clear: both;"></div>
        <div class="col-md-4 btn btnfiltro">
            <div class="filter">
                <?=Language::translate("VIEW_TRIBONEWS_FILTER_CATEGORIAS");?><br />
                <?=HTML::select("categoriaId", $categorias, $_REQUEST["categoriaId"], array("class" => "change-submit"), array("display" => Language::translate("VIEW_TRIBONEWS_FILTER_CATEGORIAS_SELECT")), array("display" => "nombre")); ?>
            </div>
        </div>
        <div class="col-md-4 btn btnfiltro">
            <div class="filter">
                <?=Language::translate("VIEW_TRIBONEWS_FILTERS_COMUNIDAD");?><br />
                <?=HTML::select("comunidadId", $comunidades, $_REQUEST["comunidadId"], array("class" => "change-submit"), array("display" => Language::translate("VIEW_TRIBONEWS_FILTER_COMUNIDADES_SELECT")), array("display" => "nombre")); ?>
            </div>
        </div>
        <div class="col-md-4 btn btnfiltro">
            <div class="filter">
                <?=Language::translate("VIEW_TRIBONEWS_FILTER_FECHA");?><br />
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
                <?=Language::translate("VIEW_TRIBONEWS_LISTADO_EMPTY");?>
            </blockquote>
        <?php } ?>

        <div style="clear: both;"></div>

        <!-- Paginación -->
        <?php $controller->setData("pag", $pag); ?>
        <?=$controller->view("modules.pagination");?>

    </form>
</div>

<div style="clear: both;"></div>
