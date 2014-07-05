<?php defined('_EXE') or die('Restricted access'); ?>

<img src="<?=Url::template("/img/tu_haces/en_corto/video.png");?>" alt="<?=Helper::sanitize($video->titulo)?>" title="<?=Helper::sanitize($video->titulo)?>" />
<br />
<div class="th_video_info">
    <div style="float: left;">
        <?php $author = new User($video->userId); ?>
    </div>
    <div>
        <span class="th_titulo"><?=Helper::sanitize($video->titulo)?></span>
    </div>
</div>
