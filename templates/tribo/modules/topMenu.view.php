<?php defined('_EXE') or die('Restricted access'); ?>

<?php $user = Registry::getUser(); ?>
<?php $config = Registry::getConfig(); ?>

<nav class="navbar" role="navigation">
    <div class='menu-bg'>
    </div>
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class='col-md-9 col-md-offset-2 topete'>
            <div class='userzone col-md-4'>
                <a href='#' class='last'>
                    <img src='<?=Url::template("/img/herramientas.png");?>' title='Herramientas' />
                </a>
                <a href='<?=Url::site("login/register");?>' class='reg'>
                    <div class='izq'></div>
                    <div class='mid'>> Regístrate</div>
                    <div class='dcha'></div>
                </a>
                <a href='<?=Url::site("account");?>'>
                    <img src='<?=Url::template("/img/user.png");?>' title='Perfil' />
                </a>
            </div>
            <div class='socialm col-md-3'>
                <a href='#'>
                    <img src='<?=Url::template("/img/twitter.png");?>' title='Twitter' />
                </a>
                <a href='#'>
                    <img src='<?=Url::template("/img/facebook.png");?>' title='Facebook' />
                </a>
                <a href='#'>
                    <img src='<?=Url::template("/img/vimeo.png");?>' title='Vimeo' />
                </a>
                <a href='#'>
                    <img src='<?=Url::template("/img/instagram.png");?>' title='Instagram' />
                </a>
                <a href='#'>
                    <img src='<?=Url::template("/img/flickr.png");?>' title='Flickr' />
                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-ex1-collapse navbar-collapse ">

                <ul class="nav navbar-nav navbar-inner col-md-9">
                    <?php $url = Registry::getUrl(); ?>
                    <?php $active = array(); ?>
                    <?php $active[$url->app][$url->action] = "active"; ?>
                    <li class='visible-xs'>
                        <a href="<?=Url::site("home");?>">Inicio</a>
                    </li>
                    <li class="<?=$active["home"]["inicio"];?>">
                        <a class="" href='<?=Url::site("home/inicio");?>'>Hi! tribo tv</a>
                    </li>
                    <li class="<?=$active["home"]["sintonizanos"];?>">
                        <a class="" href='<?=Url::site("home/sintonizanos");?>'>
                            Sintonízanos
                        </a>
                    </li>
                    <li class='dropdown'>
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Programas <b class="caret"></b></a>
                        <ul class="dropdown-menu col-md-12" id="menu1">
                            <li><a href='#'>Programa 1</a>
                            </li>
                            <li><a href='#'>Programa 2</a>
                            </li>
                            <li><a href='#'>Programa 3</a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="" href='#'>TV en directo</a>
                    </li>
                    <li class="<?=$active["home"]["tu_haces_tribo"];?>">
                        <a class="" href='<?=Url::site("home/tu_haces_tribo");?>'>Tu haces tribo</a>
                    </li>
                    <li><a class="" href='#'>Contacta</a>
                    </li>
                </ul>
                <a href='<?=Url::site("home");?>' class='logo'>
                    <img src='<?=Url::template("/img/logo.png");?>' />
                </a>
            </div>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>