<?php defined('_EXE') or die('Restricted access'); ?>

<?php if (count($programas)) { ?>
    <?php foreach ($programas as $programa) { ?>
        <div class='col-md-6 square'>
            <a href="<?=Url::site("/programas/ver/".$programa->slug);?>">
                <img src="<?=$programa->getThumbnailUrl()?>" title="<?=$programa->titulo;?>" />
            </a>
             <img class="arrow" src="<?=Url::template("img/arrow.png")?>" />
            <div class="rating"><?=HTML::showRate(rand(10, 999), 999, 10);?></div>
            <div class="sq_content">
                <div class="sq_title">
                    <a href="<?=Url::site("/programas/ver/".$programa->slug);?>">
                        <?=$programa->titulo;?>
                    </a>
                </div>
                <div class="sq_num">
                    <?=rand(10, 999); ?>
                    <i class="fa fa-heart-o"></i>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } ?>
