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
            <a href="<?=$mencion->getLink();?>" target="_blank">
                <?= $mencion->titulo; ?>
            </a>
        </h1>
        <h2>
            <?= $mencion->descripcion; ?>
        </h2>
    </div>
</div>
