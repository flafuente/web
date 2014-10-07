<?php defined('_EXE') or die('Restricted access'); ?>

<?php
$url = "/";
$capitulo = new Capitulo($evento->capituloId);
if ($capitulo->programaId) {
    $programa = new Programa($capitulo->programaId);
    $url = "programas/ver/".$programa->slug;
}
?>

<div class="video-info">

    <div class="col-md-12 vd-ruta">
        <?php echo $programa->id ? Helper::sanitize($programa->titulo) : "Tribo en directo"; ?>
    </div>

    <div class="col-md-8">
        <!--<div class="vd-codigo" style="font-size: 14px; letter-spacing: -1px;">Tribo en </div>
        <div class="vd-capitulo" style="font-size: 15px;">directo</div>-->
    </div>

    <?php if ($capitulo->id) { ?>
        <div class="col-md-4">
            <span id="likesCapitulo<?=$capitulo->id;?>">
                <?=$capitulo->likes;?>
            </span>
            <?php if ($capitulo->isLiked()) { ?>
                <?php $class = "fa-heart"; ?>
            <?php } else { ?>
                <?php $class = "fa-heart-o"; ?>
            <?php } ?>
            <i id="likeCapitulo<?=$capitulo->id;?>" class="fa <?=$class;?> like like-capitulo" data-capituloId="<?=$capitulo->id;?>"></i>
        </div>
    <?php } ?>

    <?php if ($capitulo->id) { ?>
        <div class="col-md-12">
            <div class="vd-temporada">
                <?php echo Helper::sanitize($capitulo->getProgramaTitulo()); ?>
            </div>
        </div>
    <?php } ?>

    <div class="col-md-12 video-desc">
        <?php if ($capitulo->id) { ?>
            <?php if ($capitulo->descripcion) { ?>
                    <?=Helper::sanitize($capitulo->descripcion);?>
                <?php } else { ?>
                    <?=Helper::sanitize($programa->descripcion);?>
                <?php } ?>
        <?php } else { ?>
            Emisión en directo.
        <?php } ?>

        <br />

        <div class='col-md-6 epi_button'>
            <a href="<?=Url::site($url);?>">site programa
            <strong>|</strong>
            todos los capitulos</a>
        </div>
    </div>

    <div style="clear: both;"></div>

</div>
