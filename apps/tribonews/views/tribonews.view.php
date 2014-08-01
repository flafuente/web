<?php defined('_EXE') or die('Restricted access');?>

<!-- Notícias -->
<?=$controller->view("modules.noticias");?>
<!-- /Notícias -->

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
