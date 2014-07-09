<?php defined('_EXE') or die('Restricted access'); ?>

<div class='title-line'>
    <span>WEB SERIES</span>
</div>

<?php foreach ($programas as $programa) { ?>
    <a href="<?=Url::site("programas/ver/".$programa->slug);?>">
        <div class='col-md-6 square'>
            <img src="<?=$programa->getThumbnailUrl()?>" title="<?=$programa->titulo; ?>" />
            <img class="arrow" src="<?=Url::template("img/arrow.png")?>" />
            <div class="sq_content">
                <div class="sq_title">
                    <?=$programa->subtitulo; ?>
                </div>
            </div>
        </a>
    </div>
<?php } ?>

<div class="col-md-offset-6 col-md-6 ver-todas-web">
    Ver todas las Webseries&nbsp;&nbsp;<div class="circulo-azul">+</div>
</div>
