<?php defined('_EXE') or die('Restricted access'); ?>

<?php
    //Video url
    if ($video->estadoId == 1) {
        $url = Url::site("tribonews/video/".$video->id);
    } else {
        $url = Url::site("videos/ver/".$video->id);
    }
?>

<!-- Vídeo -->
<div class="mi-video">

    <div class="col-md-6 mi-video-prev">
        <a href="<?=$url;?>">
            <img src="<?=$video->getThumbnailUrl();?>" />
        </a>
    </div>

    <div class="col-md-6" style="padding-top: 20px;">

        <span class="mivid-titulo">
            <a href="<?=$url;?>">
                <?=Helper::sanitize($video->titulo)?>
            </a>
        </span>
        <br />

        <?php if ($video->comunidadId) { ?>
            <?php $comunidad = new Comunidad($video->comunidadId); ?>
            <span class="mivid-subtitulo">
                <?=$comunidad->nombre;?>
            </span> |
        <?php } ?>

        <span class="mv-reproducciones">
            <?=$video->visitas?> reproducciones
        </span>
        <br />

        <span class="mv-fecha">
            <?=date("d/m/Y", strtotime($video->dateInsert));?> a las <?=date("H:i", strtotime($video->dateInsert));?>
        </span>

        <?php if ($video->estadoId != 1) { ?>
            <span class="btn-tribo-grey btn ladda-button editclick" data-video-id="<?=$video->id;?>" style="float: right;">
                Editar
            </span>
        <?php } ?>

    </div>
</div>
<div style="clear: both;"></div>
