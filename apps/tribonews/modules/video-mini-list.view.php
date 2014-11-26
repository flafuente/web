<?php defined('_EXE') or die('Restricted access'); ?>

<?php if ($video->id) { ?>

    <div class='col-md-6 square'>

        <!-- Título -->
        <a href="<?=Url::site("tribonews/video/".$video->id);?>">
            <img src="<?=$video->getThumbnailUrl();?>" title="<?php echo Helper::sanitize(Location::translate($video, 'titulo')); ?>" />
        </a>

        <img class="arrow" src="<?=Url::template("img/arrow.png")?>" />

        <!-- Rating -->
        <div class="rating">
            <?=HTML::showRate($video->likes, $video->visitas);?>
        </div>

        <div class="sq_content">

            <!-- Título completo -->
            <div class="sq_title">
                <a href="<?=Url::site("tribonews/video/".$video->id);?>">
                    <?=Helper::sanitize(Location::translate($video, 'titulo')); ?>
                </a>
            </div>

            <!-- Likes -->
            <div class="sq_num">
                <span id="likesVideo<?=$video->id;?>">
                    <?=$video->likes;?>
                </span>
                <?php if ($video->isLiked()) { ?>
                    <?php $class = "fa-heart"; ?>
                <?php } else { ?>
                    <?php $class = "fa-heart-o"; ?>
                <?php } ?>
                <i id="likeVideo<?=$video->id;?>" class="fa <?=$class;?> like like-video" data-videoId="<?=$video->id;?>"></i>
            </div>

        </div>

    </div>

    <div class='col-md-6 squaredesc'>

        <!-- Título completo -->
        <a href="<?=Url::site("tribonews/video/".$video->id);?>">
            <?=Helper::sanitize(Location::translate($video, 'titulo')); ?>
        </a>
        <br /><br />

        <!-- Descripción -->
        <div class="sqd_description">
            <?=Helper::sanitize(Location::translate($video, 'descripcion')); ?>
        </div>

        <!-- Info -->
        <span class="sqd_info">
            <?=Helper::sanitize(Location::translate($video, 'titulo')); ?>
        </span>

    </div>

<?php } ?>

<div style="clear: both;"></div>
