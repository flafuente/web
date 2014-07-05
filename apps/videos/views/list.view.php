<?php defined('_EXE') or die('Restricted access'); ?>

<a href="<?=Url::site("videos/nuevo");?>" class="botonsubir"><i class="fa fa-arrow-up" style="margin-right: 10px;"></i>Sube tu corto</a>

<!-- Ranking semanal -->
<?php if (count($videosRankingSemanal)) { ?>
    <h4 style="width: 183px;">Cortos más populares</h4>
    <?php foreach ($videosRankingSemanal as $video) { ?>
        <div class="col-md-3 th_video">
            <?php $controller->setData("video", $video); ?>
            <?=$controller->view("modules.video");?>
        </div>
    <?php } ?>
    <div style="clear: both;"></div><br />
<?php } ?>

<!-- Últimos cortos -->
<?php if (count($videosNovedades)) { ?>
    <h4 style="width: 124px;">Últimos Cortos</h4>
    <?php foreach ($videosNovedades as $video) { ?>
        <div class="col-md-3 th_video">
            <?php $controller->setData("video", $video); ?>
            <?=$controller->view("modules.video");?>
        </div>
    <?php } ?>
    <div style="clear: both;"></div><br />
<?php } ?>
