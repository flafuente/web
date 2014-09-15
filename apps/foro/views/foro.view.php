<?php defined('_EXE') or die('Restricted access'); ?>

<div class='title-line title-line-left'>
    <span>FORO TRIBER</span>
</div>
<div class='col-md-12'>
    <div class="square-info-foro">
        <div class="grey" style="margin-bottom: 0px;">
            INFORMACIÓN GENERAL
        </div>
    </div>
    <?php
    showTema(Url::template("img/weirdicon.png"), "Funcionamiento del foro", "Normas de utilización del Foro triber", $user->getFotoUrl(), "Ultimo post", "hace x tiempo por ".$user->username, "240", "2");
    showTema(Url::template("img/weirdicon.png"), "Funcionamiento del foro", "Normas de utilización del Foro triber", $user->getFotoUrl(), "Ultimo post", "hace x tiempo por ".$user->username, "240", "2");
    showTema(Url::template("img/weirdicon.png"), "Funcionamiento del foro", "Normas de utilización del Foro triber", $user->getFotoUrl(), "Ultimo post", "hace x tiempo por ".$user->username, "240", "2");
    showTema(Url::template("img/weirdicon.png"), "Funcionamiento del foro", "Normas de utilización del Foro triber", $user->getFotoUrl(), "Ultimo post", "hace x tiempo por ".$user->username, "240", "2");
    showTema(Url::template("img/weirdicon.png"), "Funcionamiento del foro", "Normas de utilización del Foro triber", $user->getFotoUrl(), "Ultimo post", "hace x tiempo por ".$user->username, "240", "2");
    
    ?>
    
</div>
<div class="clear: both;"></div>
<div class='col-md-12'>
    <div class="square-info-foro">
        <div class="grey" style="margin-bottom: 0px;">
            PERIODISMO CIUDADANO
        </div>
    </div>
    <?php
    showTema(Url::template("img/weirdicon.png"), "Funcionamiento del foro", "Normas de utilización del Foro triber", $user->getFotoUrl(), "Ultimo post", "hace x tiempo por ".$user->username, "240", "2");
    showTema(Url::template("img/weirdicon.png"), "Funcionamiento del foro", "Normas de utilización del Foro triber", $user->getFotoUrl(), "Ultimo post", "hace x tiempo por ".$user->username, "240", "2");
    showTema(Url::template("img/weirdicon.png"), "Funcionamiento del foro", "Normas de utilización del Foro triber", $user->getFotoUrl(), "Ultimo post", "hace x tiempo por ".$user->username, "240", "2");
    showTema(Url::template("img/weirdicon.png"), "Funcionamiento del foro", "Normas de utilización del Foro triber", $user->getFotoUrl(), "Ultimo post", "hace x tiempo por ".$user->username, "240", "2");
    showTema(Url::template("img/weirdicon.png"), "Funcionamiento del foro", "Normas de utilización del Foro triber", $user->getFotoUrl(), "Ultimo post", "hace x tiempo por ".$user->username, "240", "2");
    
    ?>
    
</div>
<div class="clear: both;"></div>
<div class='col-md-12'>
    <div class="square-info-foro">
        <div class="grey" style="margin-bottom: 0px;">
            TRIBO INVESTIGACIÓN
        </div>
    </div>
    <?php
    showTema(Url::template("img/weirdicon.png"), "Funcionamiento del foro", "Normas de utilización del Foro triber", $user->getFotoUrl(), "Ultimo post", "hace x tiempo por ".$user->username, "240", "2");
    showTema(Url::template("img/weirdicon.png"), "Funcionamiento del foro", "Normas de utilización del Foro triber", $user->getFotoUrl(), "Ultimo post", "hace x tiempo por ".$user->username, "240", "2");
    showTema(Url::template("img/weirdicon.png"), "Funcionamiento del foro", "Normas de utilización del Foro triber", $user->getFotoUrl(), "Ultimo post", "hace x tiempo por ".$user->username, "240", "2");
    ?>
    
</div>
<div class="clear: both;"></div>
<div class='col-md-12'>
    <div class="square-info-foro">
        <div class="grey" style="margin-bottom: 0px;">
            OTROS
        </div>
    </div>
    <?php
    showTema(Url::template("img/weirdicon.png"), "Funcionamiento del foro", "Normas de utilización del Foro triber", $user->getFotoUrl(), "Ultimo post", "hace x tiempo por ".$user->username, "240", "2");
    ?>
    
</div>
<div class="clear: both;"></div>


<?php
function showTema($icono, $titulo, $descripcion, $thumb, $lastpost, $lastpost_desc, $ntemas, $nactua){
    ?>
    <div class="foro_tema col-md-12 nopaddingI">
        <div class="col-md-5 nopaddingI foro_tema_titulo">
            <div class="col-md-3 foro_tema_icono">
                <img src="<?=$icono; ?>" />
            </div>
            <div class="col-md-9 foro_tema_info">
                <h1><?=$titulo; ?></h1>
                <h2><?=$descripcion; ?></h2>
            </div>
        </div>
        <div class="col-md-4 nopaddingI foro_tema_quien">
            <div class="col-md-3 foro_tema_icono">
                <img src="<?=$thumb; ?>" class="img-circle profpic" />
            </div>
            <div class="col-md-9 foro_tema_info">
                <h1><?=$lastpost; ?></h1>
                <h2><?=$lastpost_desc; ?></h2>
            </div>
        </div>
        <div class="col-md-3 nopaddingI foro_tema_tinfo">
            <div class="col-md-12 foro_tema_infoT">
                <h1><?=$ntemas; ?> temas</h1>
                <h2><?=$nactua; ?> actualizaciones</h2>
            </div>
        </div>
    </div>
    <?php
}
?>