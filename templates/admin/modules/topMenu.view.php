<?php defined('_EXE') or die('Restricted access'); ?>

<?php $config = Registry::getConfig(); ?>
<?php $user = Registry::getUser(); ?>

<div class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand logo" href="<?=Url::site();?>">
                <?=$config->get("title");?>
            </a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <?php $url = Registry::getUrl(); ?>
                <?php $active[$url->app][$url->action] = "active"; ?>
                <li class="<?=$active['admin']['users']?>">
                    <a href="<?=Url::site("admin/users")?>">
                        <span class="glyphicon glyphicon-user"></span>
                        Usuarios
                    </a>
                </li>
                <li class="<?=$active['admin']['videos']?>">
                    <a href="<?=Url::site("admin/videos")?>">
                        <span class="glyphicon glyphicon-facetime-video"></span>
                        Videos
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="<?=Url::site("login/doLogout");?>">
                        <span class="glyphicon glyphicon-off"></span>
                        Salir
                        <small><i>(<?=$user->nombre;?>)</i></small>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>