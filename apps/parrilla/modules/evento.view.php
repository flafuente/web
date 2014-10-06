<?php defined('_EXE') or die('Restricted access'); ?>

<?php
$capitulo = new Capitulo($evento->capituloId);
if ($capitulo->id) {
    $programa = new Programa($capitulo->programaId);
}
?>

<div class="parrilla_elemento">
    <div class="col-md-2 parr_hora">
        <?=Helper::sanitize($evento->getHoraInicio());?>
    </div>
    <div class="col-md-5 parr_image">
        <?php if ($capitulo->id) { ?>
            <img src="<?=$programa->getThumbnailUrl();?>" />
        <?php } ?>
    </div>
    <div class="col-md-5 parr_info">
        <span class="parr_titulo">
            <?php if ($capitulo->id) { ?>
                <?=Helper::sanitize($capitulo->getFullTitulo()); ?>
            <?php } else { ?>
                Espacio vacío
            <?php } ?>
        </span>
        <br />
        <span class="parr_descripcion">
            <?php /*if ($capitulo->descripcion) { ?>
                <?=Helper::sanitize($capitulo->descripcion);?>
            <?php } else { ?>
                <?=Helper::sanitize($programa->descripcion);?>
            <?php }*/ ?>
        </span>
    </div>
</div>
