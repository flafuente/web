<?php defined('_EXE') or die('Restricted access'); ?>

<a href="<?=Url::site("videos/nuevo");?>" class="botonsubir"><i class="fa fa-arrow-up" style="margin-right: 10px;"></i>Sube tu corto</a>

<!-- Últimos cortos -->
<?php if (count($videos)) { ?>
    <h4 style="width: 124px;">Mis videos</h4>
    <?php foreach ($videos as $video) { ?>
        <div class="col-md-3 th_video">
            <?php $controller->setData("video", $video); ?>
            <?=$controller->view("modules.video");?>
        </div>
    <?php } ?>
    <div style="clear: both;"></div><br />
<?php } ?>
