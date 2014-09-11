<?php defined('_EXE') or die('Restricted access'); ?>

<div class='col-md-12 serie_info'>

    <!-- Player -->
    <div class="col-md-12 video">
        <?php HTML::wistiaPlayer($capitulo->cdnId, 569, 300); ?>
    </div>

    <!-- Info -->
    <div class="video-info">
        <div class="col-md-12 vd-ruta">
            <a href="<?=Url::site('programas/ver/'.$programa->slug);?>">
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
            <div class="sq_num"><?=$capitulo->likes;?> <i class="fa fa-heart-o"></i>
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

    <!-- Capítulos -->
    <?php
    //Anterior
    $controller->setData("capitulo", $capitulo->getPrevious());
    echo $controller->view("modules.capitulo-mini", "programas");
    ?>

    <?php
    //Siguiente
    $controller->setData("capitulo", $capitulo->getNext());
    echo $controller->view("modules.capitulo-mini", "programas");
    ?>

    <div class='col-md-6 epi_button'>
        <a href="<?=Url::site("programas/ver/".$programa->slug);?>">
            site programa
            <strong>|</strong>
            todos los capitulos
        </a>
    </div>

    <?php $seccion = new Seccion($programa->seccionId); ?>
    <?php if ($seccion->id) { ?>
        <div class="col-md-6 ver-todas-web" style="margin-top: 30px;">
            <a href="<?=Url::site("programas/seccion/".$seccion->slug);?>">
                Ver todas las Webseries&nbsp;&nbsp;<div class="circulo-azul">+</div>
            </a>
        </div>
    <?php } ?>

</div>
