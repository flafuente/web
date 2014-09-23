<?php defined('_EXE') or die('Restricted access'); ?>

<?php $config = Registry::getConfig(); ?>
<?php $user = Registry::getUser(); ?>

<div class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
    <div class="navbar-inner">
        <ul class="nav navbar-nav">
            <?php $url = Registry::getUrl(); ?>
            <?php $active[$url->app][$url->action] = "active"; ?>
            <?php if ($user->checkPermisos("secciones")) { ?>
                <li class="<?=$active['admin']['secciones']?>">
                    <a href="<?=Url::site("admin/secciones")?>">
                        <span class="glyphicon glyphicon-star"></span>
                        Secciones
                    </a>
                </li>
            <?php } ?>
            <?php if ($user->checkPermisos("programas")) { ?>
                <li class="<?=$active['admin']['programas']?>">
                    <a href="<?=Url::site("admin/programas")?>">
                        <span class="glyphicon glyphicon-film"></span>
                        Programas
                    </a>
                </li>
            <?php } ?>
            <?php if ($user->checkPermisos("capitulos")) { ?>
                <li class="<?=$active['admin']['capitulos']?>">
                    <a href="<?=Url::site("admin/capitulos")?>">
                        <span class="glyphicon glyphicon-th-list"></span>
                        Capítulos
                    </a>
                </li>
            <?php } ?>
            <?php if ($user->checkPermisos("parrilla")) { ?>
                <li class="<?=$active['admin']['parrilla']?>">
                    <a href="<?=Url::site("admin/parrilla")?>">
                        <span class="glyphicon glyphicon-th"></span>
                        Parilla
                    </a>
                </li>
            <?php } ?>
            <?php if ($user->checkPermisos("usuarios")) { ?>
                <li class="<?=$active['admin']['users']?>">
                    <a href="<?=Url::site("admin/users")?>">
                        <span class="glyphicon glyphicon-user"></span>
                        Usuarios
                    </a>
                </li>
            <?php } ?>
            <?php if ($user->checkPermisos("videos")) { ?>
                <li class="<?=$active['admin']['videos']?>">
                    <a href="<?=Url::site("admin/videos")?>">
                        <span class="glyphicon glyphicon-facetime-video"></span>
                        Videos
                    </a>
                </li>
            <?php } ?>
            <?php if ($user->checkPermisos("categorias")) { ?>
                <li class="<?=$active['admin']['categorias']?>">
                    <a href="<?=Url::site("admin/categorias")?>">
                        <span class="glyphicon glyphicon-bookmark"></span>
                        Categorías
                    </a>
                </li>
            <?php } ?>
            <?php if ($user->checkPermisos("tags")) { ?>
                <li class="<?=$active['admin']['tags']?>">
                    <a href="<?=Url::site("admin/tags")?>">
                        <span class="glyphicon glyphicon-tag"></span>
                        Tags
                    </a>
                </li>
            <?php } ?>
            <?php if ($user->checkPermisos("contactos")) { ?>
                <li class="<?=$active['admin']['contactos']?>">
                    <a href="<?=Url::site("admin/contactos")?>">
                        <span class="glyphicon glyphicon-envelope"></span>
                        Contactos
                    </a>
                </li>
            <?php } ?>
            <?php if ($user->checkPermisos("slideshow")) { ?>
                <li class="<?=$active['admin']['slideshow']?>">
                    <a href="<?=Url::site("admin/slideshow")?>">
                        <span class="glyphicon glyphicon-picture"></span>
                        Slideshow
                    </a>
                </li>
            <?php } ?>
            <?php if ($user->checkPermisos("articulos")) { ?>
                <li class="<?=$active['admin']['articulos']?>">
                    <a href="<?=Url::site("admin/articulos")?>">
                        <span class="glyphicon glyphicon-pencil"></span>
                        Artículos
                    </a>
                </li>
            <?php } ?>
        </ul>
        <ul class="nav navbar-nav navbar-right" style="margin-right: 20px">
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
