<?php defined('_EXE') or die('Restricted access'); ?>

<div class='col-md-12'>
    <div class="square-info-foro">
        <div class="grey" style="margin-bottom: 0px;">
            SALA DE PRENSA > NOTA DE PRENSA
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
                <h2><?= $nota->fecha; ?></h2>
                <h1><?= $nota->titulo; ?></h1>
                <h3><?= $nota->descripcion; ?></h3>
            </div>
        </div>
        <div style="clear: both;"></div>
        <hr />
        <div class="nota_content">
            <?= $nota->nota; ?>

            <?php if ($nota->archivo) { ?>
                <br /><br />
                <img src="<?=Url::template("img/pdficon.png");?>" /><a href="<?=$nota->getArchivoUrl();?>">
                    Descargar Adjunto
                </a>
            <?php } ?>
        </div>
    </div>

</div>
