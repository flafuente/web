<?php defined('_EXE') or die('Restricted access');?>

<?php if ($welcome) { ?>
    <?=$controller->view("modules.welcome");?>
<?php } ?>

<div class='title-line'>
    <span>
        <?=Language::translate("VIEW_TRIBONEWS_LISTADO_TITLE")?>
    </span>
</div>

<?php if (count($videos)) { ?>

    <?php foreach ($videos as $video) { ?>
        <?php $controller->setData("video", $video); ?>
        <?=$controller->view("modules.video-mini");?>
    <?php } ?>

    <div class="col-md-offset-6 col-md-6 ver-todas-web">
        <a href="<?=Url::site("tribonews/historico");?>">
            <?=Language::translate("VIEW_TRIBONEWS_LISTADO_HISTORICO")?>&nbsp;&nbsp;
            <div class="circulo-azul">+</div>
        </a>
    </div>

<?php } ?>

<div style="clear: both;"></div>

<br /><br />

<!-- Mapa -->
<?php if (count($videos)) { ?>
    <?php $controller->setData("videos", $videos); ?>
    <?=$controller->view("modules.mapa");?>
    <br /><br />
<?php } ?>

<!-- Registro -->
<?php $user = Registry::getUser(); ?>
<?php if (!$user->id) { ?>
    <?=$controller->view("modules.registro");?>
<?php } ?>
