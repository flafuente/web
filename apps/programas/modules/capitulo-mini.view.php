<?php defined('_EXE') or die('Restricted access'); ?>

<?php $likes = rand(0, 1000); ?>

<div class='col-md-6 square'>
    <img src="<?=$capitulo->getThumbnailUrl();?>" title="<?php echo $capitulo->getFullNombre(); ?>" />
    <img class="arrow" src="<?=Url::template("img/arrow.png")?>" />
    <div class="rating">
        <?=HTML::showRate($likes, 1000);?>
    </div>
    <div class="sq_content">
        <div class="sq_title">
            <a href="<?=Url::site("player/".$capitulo->id);?>">
                <?php echo $capitulo->getFullNombre(); ?>
            </a>
        </div>
        <div class="sq_num">
         <?php echo $likes; ?>
            <i class="fa fa-heart-o"></i>
        </div>
    </div>
</div>
<div class='col-md-6 squaredesc'>
    <a  class="sqd_title" href="<?=Url::site("player/".$capitulo->id);?>">
        <?php echo $capitulo->getFullNombre(); ?>
    </a>
    <br /><br />
    <div class="sqd_description"><?php echo $capitulo->descripcion; ?></div>
    <span class="sqd_info"><?php echo $capitulo->duracion; ?> | <?php echo $capitulo->getFullNombre(); ?></span>
</div>
<div style="clear: both;"></div>
