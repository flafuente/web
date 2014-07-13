<?php defined('_EXE') or die('Restricted access'); ?>

<?php $user = Registry::getUser(); ?>

<a class='rsep login' href='#'>
    <img src='<?=Url::template("/img/user.png");?>' title='Login' />
</a>
<div class="login_form" style="display: none;">
    <?php if (!$user->id) { ?>
        <div class="forgot col-md-8"><img style="float: left;" src='<?=Url::template("/img/user.png");?>' title='Login' /><h1>&nbsp;&nbsp;&nbsp;ZONA TRIBER</h1></div>
        <div class="forgot col-md-4"><button type="submit" class="btn btn-tribo-grey ladda-button">Registrate</button></div>
        <div style="clear: both;"></div>
        <br />
        <form class="l_form ajax" role="form" method="post" action="<?=Url::site("login/doLogin")?>">
            <div class="col-md-12"><input class="form-control" type="text" name="login" placeholder="Usuario" value="" /></div>
            <div class="col-md-12"><input class="form-control" type="password" name="password" placeholder="Password"></div>
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
        Bienvenido <?=$user->nombre;?>!
    <?php } ?>
</div>
