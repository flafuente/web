<?php defined('_EXE') or die('Restricted access'); ?>

<?php
/*
$nota = new stdClass();
$nota->icono = Url::template("img/weirdicon.png");
$nota->titulo = "Funcionamiento del foro";
$nota->descripcion = "Normas de utilización del Foro triber";
$nota->fecha = date("d / m / Y");
*/
?>
<div class="prensa col-md-12 nopaddingI">
    <div class="col-md-3 nopaddingI">
        <div class="col-md-12 prensa_fecha nopaddingI">
            <h1><?=Helper::sanitize($nota->fecha); ?></h1>
        </div>
        <div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="col-md-12 nopaddingI">
            <?php
            if($nota->icono != ""){
                $span = "10";
                ?>
                <div class="col-md-2 prensa_descripcion nopaddingI">
                    <img src="<?=Helper::sanitize($nota->icono); ?>" />
                </div>
                <?php
            }else{
                $span = "12";
            }
            ?>
            <div class="col-md-<?=$span;?> prensa_descripcion">
                <h1><a href="<?=Url::site("prensa/nota")."/".rand(1,999);?>"><?= $nota->titulo; ?></a></h1>
                <h2><?= $nota->descripcion; ?></h2>
            </div>
        </div>
    </div>
</div>