<?php defined('_EXE') or die('Restricted access'); ?>

<div class='col-md-12 serie_info'>
    <div class="serie_title">
        <?=Helper::sanitize($programa->titulo);?>
    </div>
    <div class="serie_when">
        <?=Helper::sanitize($programa->subtitulo);?>
    </div>
    <br />
    <div class="serie_description">
        <?=Helper::sanitize($programa->descripcion);?>
    </div>
    <div style="clear: both;"></div>
    <div class='col-md-offset-6 col-md-6 epi_button'>
        <a href="<?=Url::site("programas/n_programa");?>">site programa</a> <strong>|</strong> <a href="<?=Url::site("episodios/n_programa/all");?>">todos los capitulos</a>
    </div>
</div>

<?php
if (count($capitulos)) {
    foreach ($capitulos as $capitulo) {
        $controller->setData("capitulo", $capitulo);
        echo $controller->view("modules.capitulo-mini");
    }
}
