<?php defined('_EXE') or die('Restricted access'); ?>

<?php $limit = 4; ?>

<div class='title-line'>
    <span><?=$seccion->nombre; ?></span>
</div>

<div class="programas">
    <?php if (count($programas)) { ?>
        <?php foreach ($programas as $i=>$programa) { ?>
            <?php if ($i>=$limit) { ?>
                <?php $class = "hidden"; ?>
            <?php } ?>
            <a href="<?=Url::site("programas/ver/".$programa->slug);?>" class="<?=$class;?>">
                <div class='col-md-6 square'>
                    <img src="<?=$programa->getThumbnailUrl()?>" title="<?=$programa->titulo; ?>" />
                    <img class="arrow" src="<?=Url::template("img/arrow.png")?>" />
                    <div class="sq_content">
                        <div class="sq_title">
                            <?=$programa->subtitulo; ?>
                        </div>
                    </div>
                </div>
            </a>
        <?php } ?>
        <?php if ($i>=$limit) { ?>
            <div class="col-md-offset-6 col-md-6 ver-todas-web">
                Ver más&nbsp;&nbsp;<div class="circulo-azul more">+</div>
            </div>
        <?php } ?>
    <?php } ?>
</div>

<script>
    var limit = <?=$limit;?>;
    var current = limit;
    var total = <?=$i?>;
    $('.programas').on('click','.ver-todas-web', function () {
        $('.programas a.hidden:lt(<?=$limit?>)').css('visibility','visible').hide().fadeIn().removeClass('hidden');
        current += limit
        if (current >= total) {
            $("div.ver-todas-web").hide();
        }
    });
</script>
