<?php defined('_EXE') or die('Restricted access'); ?>

<?php if ($capitulo->id) { ?>

    <div class='col-md-6 square'>

        <a href="<?=Url::site("reproductor/capitulo/".$capitulo->id);?>">
            <img src="<?=$capitulo->getThumbnailUrl();?>" title="<?=Helper::sanitize($capitulo->titulo); ?>" />
        </a>

        <img class="arrow" src="<?=Url::template("img/arrow.png")?>" />

        <div class="rating">
            <?=HTML::showRate($capitulo->likes, 1000);?>
        </div>

        <div class="sq_content">

            <div class="sq_title">
                <a href="<?=Url::site("reproductor/capitulo/".$capitulo->id);?>">
                    <?=Helper::sanitize($capitulo->getFullTitulo()); ?>
                </a>
            </div>

            <div class="sq_num">
             <?php echo $capitulo->likes; ?>
                <i class="fa fa-heart-o"></i>
            </div>

        </div>

    </div>

    <div class='col-md-6 squaredesc'>

        <a  class="sqd_title" href="<?=Url::site("reproductor/capitulo/".$capitulo->id);?>">
            <?=Helper::sanitize($capitulo->getFullTitulo()); ?>
        </a>
        <br /><br />

        <div class="sqd_description">
            <?=Helper::sanitize($capitulo->descripcion); ?>
        </div>

        <span class="sqd_info">
            <?php echo $capitulo->duracion; ?> |
            <?=Helper::sanitize($capitulo->titulo); ?>
        </span>

    </div>

<?php } ?>

<div style="clear: both;"></div>
