<?php defined('_EXE') or die('Restricted access'); ?>

<div class='col-md-6 square'>
    <a href="<?=Url::site("tribonews/video/".$video->id);?>">
        <img src="<?=$video->getThumbnailUrl();?>" title="<?php echo Helper::sanitize($video->titulo); ?>" />
        <img class="arrow" src="<?=Url::template("img/arrow.png")?>" />
        <div class="sq_content">
            <div class="sq_title">
                <?php echo Helper::sanitize($video->titulo); ?>
            </div>
        </div>
    </a>
</div>
