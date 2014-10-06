<?php defined('_EXE') or die('Restricted access'); ?>

<?php $capitulo = new Capitulo($evento->capituloId); ?>
<?php $programa = new Programa($capitulo->programaId); ?>

<div class="parrilla_elemento">
    <div class="col-md-2 parr_hora">
        <?=Helper::sanitize($evento->getHoraInicio());?>
    </div>
    <div class="col-md-5 parr_image">
        <img src="<?=$programa->getThumbnailUrl();?>" />
    </div>
    <div class="col-md-5 parr_info">
        <span class="parr_titulo">
            <?=Helper::sanitize($capitulo->getFullTitulo()); ?>
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
