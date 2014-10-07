<?php defined('_EXE') or die('Restricted access'); ?>

<?php if ($capitulo->id) { ?>

    <?php
        $url = "#";
        if ($capitulo->cdnId) {
            $url = Url::site("reproductor/capitulo/".$capitulo->id);
        }
    ?>

    <div class='col-md-6 square'>

        <!-- Título -->
        <a href="<?=$url;?>">
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
                <a href="<?=$url;?>">
                    <?=Helper::sanitize($capitulo->getFullTitulo()); ?>
                </a>
            </div>

            <!-- Likes -->
            <div class="sq_num">
                <span id="likesCapitulo<?=$capitulo->id;?>">
                    <?=$capitulo->likes;?>
                </span>
                <?php if ($capitulo->isLiked()) { ?>
                    <?php $class = "fa-heart"; ?>
                <?php } else { ?>
                    <?php $class = "fa-heart-o"; ?>
                <?php } ?>
                <i id="likeCapitulo<?=$capitulo->id;?>" class="fa <?=$class;?> like like-capitulo" data-capituloId="<?=$capitulo->id;?>"></i>
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
        <div class="sqd_description sm">
            <?=Helper::sanitize($capitulo->descripcion); ?>
        </div>

        <!-- Info -->
        <span class="sqd_info">
            <!-- Duración -->
            <?php if ($capitulo->duracion && $capitulo->duracion != "00:00:00") { ?>
                <?=Helper::sanitize($capitulo->duracion);?> |
            <?php  } ?>
            <!-- Título -->
            <?=Helper::sanitize($capitulo->titulo); ?>
        </span>

    </div>

<?php } ?>

<div style="clear: both;"></div>
