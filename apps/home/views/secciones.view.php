<?php defined('_EXE') or die('Restricted access'); ?>

<?php foreach ($categorias as $categoria) { ?>
    <div class='col-md-6 square'>
        <img src="<?=$categoria->getThumbnailUrl()?>" title="<?=$categoria->nombre;?>" />
         <img class="arrow" src="<?=Url::template("img/arrow.png")?>" />
        <div class="rating"><?=HTML::showRate(rand(10, 999), 999, 10);?></div>
        <div class="sq_content">
            <div class="sq_title">
                <a href="<?=Url::site("secciones/".$categoria->slug);?>">
                    <?=$categoria->nombre;?>
                </a>
            </div>
            <div class="sq_num">
                <?=rand(10, 999); ?>
                <i class="fa fa-heart-o"></i>
            </div>
        </div>
    </div>
<?php } ?>
