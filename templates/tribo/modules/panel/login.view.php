<?php defined('_EXE') or die('Restricted access'); ?>

<?php $user = Registry::getUser(); ?>

<a class='rsep login' href='#'>
<?php
$stl = "";
if (!$user->id) {
    ?><img src='<?=Url::template("/img/user.png");?>' title='Login' /><?php
} else {
    ?><img src="<?=$user->getFotoUrl();?>" class="img-circle profpic"><?php
    //First login
    if ($_GET["a"] == true) {
        $stl .= "display: block;";
    } else {
        $stl .= "display: none;";
    }
    $stl .= "margin-top: -40px; width: 345px; height: 175px; padding: 0px;";
}
?>
</a>

<div class="login_form" style="<?=$stl;?>">
    <?php if (!$user->id) { ?>
        <div class="forgot col-md-8"><img class="imgmdl" src='<?=Url::template("/img/user.png");?>' title='Login' /><h1>&nbsp;&nbsp;&nbsp;ZONA TRIBER</h1></div>
        <div class="forgot col-md-4">
            <a href="<?=Url::site("registro");?>" class="btn btn-tribo-grey ladda-button">
                Registrate
            </a>
        </div>
        <div style="clear: both;"></div>
        <br />
        <form class="l_form ajax" role="form" method="post" action="<?=Url::site("login/doLogin")?>">
            <div class="col-md-12"><input class="form-control" type="text" name="login" placeholder="Usuario" value="" /></div>
            <div class="col-md-12"><input class="form-control" type="password" name="password" placeholder="Password"></div>
            <div class="col-md-12">
                <input type="checkbox" value="1" name="remember"> Recordar
            </div>
            <div class="forgot col-md-8">
                <a href="<?=Url::site("login/recovery");?>">
                    ¿has olvidado tu contraseña?
                </a>
            </div>
            <div class="col-md-4 l-right">
                <?=HTML::formButton("btn-tribo-blue", null, "Entra", array(
                        "data-app" => "login",
                        "data-action" => "doLogin"
                    )
                );?>
            </div>
            <div style="clear: both;"></div>
        </form>
    <?php } else { ?>
        <div class="forgot col-md-8">
            <img src="<?=$user->getFotoUrl();?>" class="imgmdl img-circle profpic" title='<?=$user->nombre;?>' />
            <h1 class="utitle">
                &nbsp;&nbsp;&nbsp;
                <span class="uname">
                    <?=$user->nombre;?>
                </span>
                 -
                <a href="<?=Url::site("perfil")?>" class="proflink">
                    Mi Perfil
                </a>
            </h1>
        </div>
        <div style="clear: both;"></div>
        <div class="profinfo">
            <ul>
                <li>Mis Videos
                    <ul>
                        <!-- Vídeos pendientes -->
                        <li style="list-style-image: url('<?=Url::template("/img/dot.png");?>');">
                            <a href="<?=Url::site("videos/pendientes")?>">
                                Videos pendientes
                            </a>
                            <?php $videos = count(Video::select(array(
                                "userId" => $user->id,
                                "estadoId" => 0
                            ))); ?>
                            (<span style="color: #c42422;"><?=$videos;?></span>)
                        </li>
                        <!-- Vídeos emitidos -->
                        <li style="list-style-image: url('<?=Url::template("/img/dot.png");?>');">
                            <a href="<?=Url::site("videos/emitidos")?>">
                                Videos emitidos
                            </a>
                            <?php $videos = count(Video::select(array(
                                "userId" => $user->id,
                                "estadoId" => 1
                            ))); ?>
                            (<span style="color: #c42422;"><?=$videos;?></span>)
                        </li>
                        <!-- Vídeos rechazados -->
                        <li style="list-style-image: url('<?=Url::template("/img/dot.png");?>');">
                            <a href="<?=Url::site("videos/rechazados")?>">
                                Videos rechazados
                            </a>
                            <?php $videos = count(Video::select(array(
                                "userId" => $user->id,
                                "estadoId" => 3
                            ))); ?>
                            (<span style="color: #c42422;"><?=$videos;?></span>)
                        </li>
                    </ul>
                </li>
            <li>
                <a href="<?=Url::site("perfil")?>">
                    Mi perfil
                </a>
            </li>
        </div>
        <div class="profbottom">
            <div class="col-md-6">
                <a class="btn-tribo-blue btn ladda-button" data-style="slide-left" href="<?=Url::site("videos?uplvid");?>">
                    <i class="fa fa-long-arrow-up"></i>
                    &nbsp;&nbsp;Subir Video
                </a>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <a data-link="#closeses" class="aclose btn-tribo-purple btn ladda-button" data-style="slide-right" href="<?=Url::site("login/doLogout");?>">
                    <i class="fa fa-long-arrow-left"></i>
                    &nbsp;&nbsp;Salir
                </a>
            </div>
        </div>
    <?php } ?>
</div>
