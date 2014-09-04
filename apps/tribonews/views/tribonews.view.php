<?php defined('_EXE') or die('Restricted access');?>

<div class='title-line'>
    <span>ÚLTIMAS NOTICIAS</span>
</div>

<?php if (count($videos)) { ?>

    <?php foreach ($videos as $video) { ?>
        <?php $controller->setData("video", $video); ?>
        <?=$controller->view("modules.video-mini");?>
    <?php } ?>

    <div class="col-md-offset-6 col-md-6 ver-todas-web">
        <a href="<?=Url::site("tribonews/historico");?>">
            Ver histórico de noticias&nbsp;&nbsp;
            <div class="circulo-azul">+</div>
        </a>
    </div>

<?php } ?>

<div style="clear: both;"></div>

<br /><br />

<!-- Mapa -->
<?=$controller->view("modules.mapa");?>
<!-- /Mapa -->

<br /><br />

<!-- Registro -->
<?php $user = Registry::getUser(); ?>
<?php if (!$user->id) { ?>
    <?=$controller->view("modules.registro");?>
<?php } ?>
<!-- /Registro -->
