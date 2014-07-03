<?php defined('_EXE') or die('Restricted access'); ?>

<img src="<?=Url::template("/img/tu_haces/en_corto/video.png");?>" alt="<?=Helper::sanitize($video->titulo)?>" title="<?=Helper::sanitize($video->titulo)?>" />
<br />
<div class="th_video_info">
    <div style="float: left;">
        <?php $author = new User($video->userId); ?>
        <img style="width: 34px;" src="<?=Url::template("/img/tu_haces/en_corto/user_icon.png");?>" alt="<?=Helper::sanitize($author->nombre)?>" title="<?=Helper::sanitize($author->nombre)?>" />
    </div>
    <div>
        <span class="th_titulo"><?=Helper::sanitize($video->titulo)?></span>
        <br />
        <span class="th_hace">De <strong><?=Helper::sanitize($author->nombre)?></strong> hace <?=HTML::relativeDate($video->dateInsert);?></span>
    </div>
</div>