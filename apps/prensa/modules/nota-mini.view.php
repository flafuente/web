<?php defined('_EXE') or die('Restricted access'); ?>

<div class="prensa col-md-12 nopaddingI">
    <div class="col-md-2 nopaddingI">
        <div class="col-md-12 prensa_fecha nopaddingI">
            <h1><?=Helper::humanDate($nota->fecha); ?></h1>
        </div>
        <div>
        </div>
    </div>
    <div class="col-md-10">
        <div class="col-md-12 nopaddingI">
            <?php
            if ($nota->imagen) {
                $span = "10";
                ?>
                <div class="col-md-2 prensa_descripcion nopaddingI">
                    <img src="<?=$nota->getImagenUrl();?>" width="74px" class="img-rounded" />
                </div>
                <?php
            } else {
                $span = "12";
            }
            ?>
            <div class="col-md-<?=$span;?> prensa_descripcion">
                <h1>
                    <a href="<?=Url::site("prensa/nota/".$nota->id);?>">
                        <?= $nota->titulo; ?>
                    </a>
                </h1>
                <h2>
                    <?= $nota->descripcion; ?>
                </h2>
            </div>
        </div>
    </div>
</div>
