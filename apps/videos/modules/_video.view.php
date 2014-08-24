<?php defined('_EXE') or die('Restricted access'); ?>

<a href="<?=Url::site("videos/ver/".$video->id);?>">
    <img src="<?=Url::template("/img/tu_haces/en_corto/video.png");?>" alt="<?=Helper::sanitize($video->titulo)?>" title="<?=Helper::sanitize($video->titulo)?>" />
    <br />
    <div class="th_video_info">
        <?=Helper::sanitize($video->titulo)?>
    </div>
</a>
