<?php defined('_EXE') or die('Restricted access'); ?>

<div class="prensa col-md-12">
    <?php
    if ($mencion->imagen) {
        $span = "10";
        ?>
        <div class="col-md-2 prensa_descripcion nopaddingI">
            <img src="<?=$mencion->getImagenUrl();?>" width="74px" class="img-rounded" />
        </div>
        <?php
    } else {
        $span = "12";
    }
    ?>
    <div class="col-md-<?=$span;?> prensa_descripcion">
        <h1>
            <?php if (!$mencion->archivo) { ?>
                <a href="<?=$mencion->getLink();?>" target="_blank">
            <?php } else { ?>
                <a href="<?=$mencion->getArchivoUrl();?>">
            <?php } ?>
                <?= Location::translate($mencion, 'titulo'); ?>
            </a>
        </h1>
        <h2>
            <?= Location::translate($mencion, 'descripcion'); ?>
        </h2>
    </div>
</div>
