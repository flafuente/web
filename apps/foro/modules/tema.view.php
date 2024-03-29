<?php defined('_EXE') or die('Restricted access'); ?>

<?php
/*
$temaEjemplo->titulo = "No sé como crear un post y no encuentro cómo borrarlos";
$temaEjemplo->autor = $user->username;
$temaEjemplo->thumb = $user->getFotoUrl();
$temaEjemplo->lastcomment = "27";
$temaEjemplo->lastcomment_autor = "Felipe Blabla";
$temaEjemplo->lasttribers = Array($user->getFotoUrl(), $user->getFotoUrl(), $user->getFotoUrl(), $user->getFotoUrl());
$temaEjemplo->ntribers = 10;
*/
?>
<div class="foro_tema col-md-12">
    <div class="col-md-2 nopaddingI foro_tema_titulo bigprofdiv">
        <img src="<?=Helper::sanitize($tema->thumb); ?>" class="img-circle profpic big" />
    </div>
    <div class="col-md-5 nopaddingI foro_tema_quien">
        <div class="col-md-12 foro_tema_info">
            <h1><?=Helper::sanitize($tema->titulo); ?></h1>
            <h2>por <span><?=Helper::sanitize($tema->autor); ?></span></h2>
        </div>
    </div>
    <div class="col-md-5 nopaddingI foro_tema_tinfo">
        <div class="col-md-12 foro_tema_infoTemas">
            <?php
            foreach($tema->lasttribers as $tribers){
                ?>
                <img src="<?=Helper::sanitize($tribers); ?>" class="img-circle profpic small floated" />
                <?php
            }
            if($tema->ntribers>0){
                ?>
                <div class="usercirle floated">+<?=Helper::sanitize($tema->ntribers); ?></div>
                <?php
            }
            ?>
            <div style="clear: both;"></div>
            <h2><strong>último comentario</strong> hace <strong><?=Helper::sanitize($tema->lastcomment); ?></strong> por <span><?=Helper::sanitize($tema->lastcomment_autor); ?></span></h2>
        </div>
    </div>
</div>