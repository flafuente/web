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

        <span class="mv-reproducciones" style="float: none;">
            <?=$video->visitas?> reproducciones
        </span>
        <br />

        <span class="mv-fecha">
            <?=date("d/m/Y", strtotime($video->dateInsert));?> a las <?=date("H:i", strtotime($video->dateInsert));?>
        </span>

        <?php if ($video->estadoId != 1) { ?>
            <a href="<?=$url?>" class="btn-tribo-grey btn ladda-button" style="float: right;">
                Editar
            </a>
        <?php } ?>

    </div>
</div>
<div style="clear: both;"></div>
