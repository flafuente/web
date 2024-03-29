<?php defined('_EXE') or die('Restricted access'); ?>

<div class='col-md-12'>
    <div class="square-info-foro">
        <div class="grey" style="margin-bottom: 0px;">
           <?=Language::translate("VIEW_PRENSA_VER_TITLE");?>
        </div>
    </div>
    <div class="nota_prensa">
        <div class="nota_header">
            <div class="col-md-4 nopaddingI">
                <?php if ($nota->imagen) { ?>
                    <img src="<?=$nota->getImagenUrl(); ?>" />
                <?php } ?>
            </div>
            <div class="col-md-8">
                <h2><?= Helper::humanDate($nota->fecha); ?></h2>
                <h1><?= Location::translate($nota, 'titulo'); ?></h1>
                <h3><?= Location::translate($nota, 'descripcion'); ?></h3>
            </div>
        </div>
        <div style="clear: both;"></div>
        <hr />
        <div class="nota_content">
            <?= $nota->nota; ?>

            <?php if ($nota->archivo) { ?>
                <br /><br />
                <img src="<?=Url::template("img/pdficon.png");?>" /><a href="<?=$nota->getArchivoUrl();?>">
                    <?=Language::translate("VIEW_PRENSA_VER_DOWNLOAD");?>
                </a>
            <?php } ?>
        </div>
    </div>

</div>
