<?php defined('_EXE') or die('Restricted access'); ?>

<?php if ($capitulo->id) { ?>

    <div class='col-md-6 square'>

        <!-- Título -->
        <a href="<?=Url::site("reproductor/capitulo/".$capitulo->id);?>">
            <img src="<?=$capitulo->getThumbnailUrl();?>" title="<?=Helper::sanitize($capitulo->titulo); ?>" />
        </a>

        <img class="arrow" src="<?=Url::template("img/arrow.png")?>" />

        <!-- Rating -->
        <div class="rating">
            <?=HTML::showRate($capitulo->likes, $capitulo->visitas);?>
        </div>

        <div class="sq_content">

            <!-- Título completo -->
            <div class="sq_title">
                <a href="<?=Url::site("reproductor/capitulo/".$capitulo->id);?>">
                    <?=Helper::sanitize($capitulo->getFullTitulo()); ?>
                </a>
            </div>

            <!-- Likes -->
            <div class="sq_num">
                <?php echo $capitulo->likes; ?>
                <i class="fa fa-heart-o"></i>
            </div>

        </div>

    </div>

    <div class='col-md-6 squaredesc'>

        <!-- Título completo -->
        <a  class="sqd_title" href="<?=Url::site("reproductor/capitulo/".$capitulo->id);?>">
            <?=Helper::sanitize($capitulo->getFullTitulo()); ?>
        </a>
        <br /><br />

        <!-- Descripción -->
        <div class="sqd_description">
            <?=Helper::sanitize($capitulo->descripcion); ?>
        </div>

        <!-- Info -->
        <span class="sqd_info">
            <?php echo $capitulo->duracion; ?> |
            <?=Helper::sanitize($capitulo->titulo); ?>
        </span>

    </div>

<?php } ?>

<div style="clear: both;"></div>
