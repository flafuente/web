<?php defined('_EXE') or die('Restricted access'); ?>

<div class='col-md-12 serie_info'>
    <div class="col-md-12 video"></div>
    <div class="video-info">
        <div class="col-md-12 vd-ruta">
            <a href="<?=Url::site('programas/'.$programa->slug);?>">
                <?=Helper::sanitize($programa->titulo);?>
            </a>
             /
            Capítulos
        </div>
        <div class="col-md-8">
            <div class="vd-codigo">
                <?=$capitulo->getNumero();?> |
            </div>
            <div class="vd-capitulo">
                <?=Helper::sanitize($capitulo->titulo);?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="sq_num">568 <i class="fa fa-heart-o"></i>
            </div>
        </div>
        <div class="col-md-12">
            <div class="vd-attr">
                <?=Helper::sanitize($capitulo->duracion);?> |
                <?=Helper::sanitize($capitulo->fechaEmision);?> |
            </div>
            <div class="vd-temporada">
                TEMPORADA <?=$capitulo->temporada;?>
            </div>
        </div>
        <div class="col-md-12 video-desc">
            <?=Helper::sanitize($capitulo->descripcion);?>
        </div>
        <div style="clear: both;"></div>
    </div>

    <?php
    //Listado de capítulos
    if (count($capitulos)) {
        foreach ($capitulos as $capitulo) {
            $controller->setData("capitulo", $capitulo);
            echo $controller->view("modules.capitulo-mini", "programas");
        }
    } ?>

    <div class='col-md-6 epi_button'>
        <a href="<?=Url::site("programas/n_programa");?>">site programa</a>
        <strong>|</strong>
        <a href="<?=Url::site("episodios/n_programa/all");?>">todos los capitulos</a>
    </div>
    <div class="col-md-6 ver-todas-web" style="margin-top: 30px;">
        Ver todas las Webseries&nbsp;&nbsp;<div class="circulo-azul">+</div>
    </div>
</div>
