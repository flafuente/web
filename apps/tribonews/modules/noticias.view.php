<?php defined('_EXE') or die('Restricted access'); ?>

<div class='title-line'>
    <span>ÚLTIMAS NOTICIAS</span>
</div>

<?php if (count($videos)) { ?>
    <?php foreach ($videos as $video) { ?>
        <?php $controller->setData("video", $video); ?>
        <?=$controller->view("modules.videoMini");?>
    <?php } ?>

    <div class="col-md-offset-6 col-md-6 ver-todas-web">
        <a href="<?=Url::site("historiconoticias");?>">
            Ver histórico de noticias&nbsp;&nbsp;
            <div class="circulo-azul">+</div>
        </a>
    </div>

<?php } ?>

<div style="clear: both;"></div>
