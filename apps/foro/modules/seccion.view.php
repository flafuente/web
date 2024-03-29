<?php defined('_EXE') or die('Restricted access'); ?>

<div class="foro_tema col-md-12 nopaddingI">
    <div class="col-md-5 nopaddingI foro_tema_titulo">
        <div class="col-md-3 foro_tema_icono">
            <img src="<?=Helper::sanitize($seccion->icono); ?>" />
        </div>
        <div class="col-md-9 foro_tema_info">
            <h1><?=Helper::sanitize($seccion->titulo); ?></h1>
            <h2><?=Helper::sanitize($seccion->descripcion); ?></h2>
        </div>
    </div>
    <div class="col-md-4 nopaddingI foro_tema_quien">
        <div class="col-md-3 foro_tema_icono">
            <img src="<?=Helper::sanitize($seccion->thumb); ?>" class="img-circle profpic" />
        </div>
        <div class="col-md-9 foro_tema_info">
            <h1><?=Helper::sanitize($seccion->lastpost); ?></h1>
            <h2><?=Helper::sanitize($seccion->lastpost_desc); ?></h2>
        </div>
    </div>
    <div class="col-md-3 nopaddingI foro_tema_tinfo">
        <div class="col-md-12 foro_tema_infoT">
            <h1><?=Helper::sanitize($seccion->ntemas); ?> temas</h1>
            <h2><?=Helper::sanitize($seccion->nactua); ?> actualizaciones</h2>
        </div>
    </div>
</div>