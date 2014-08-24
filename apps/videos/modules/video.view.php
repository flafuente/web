<?php defined('_EXE') or die('Restricted access'); ?>

<div class="mi-video">
    <div class="col-md-6 mi-video-prev">
        <img src="<?=Url::template("img/programas/malviviendo.jpg");?>" />
    </div>
    <div class="col-md-6" style="padding-top: 20px;">
        <span class="mivid-titulo">
            <?=Helper::sanitize($video->titulo)?>
        </span>
        <br />
        <span class="mivid-subtitulo">
            Los vídeos no tienen subtítulos
        </span>
        <br />
        <span class="mv-fecha">
            <?=date("d/m/Y", strtotime($video->dateInsert));?> a las <?=date("H:i", strtotime($video->dateInsert));?>
        </span>
        <a class="btn-tribo-grey btn ladda-button" href="<?=Url::site("videos/ver/".$video->id);?>" style="float: right;">
            Editar
        </a>
    </div>
</div>
<div style="clear: both;"></div>
