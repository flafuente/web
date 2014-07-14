<?php defined('_EXE') or die('Restricted access'); ?>

<div class='col-md-12'>
    <div class='video-info' style="padding: 5px;">
        <div id="haztetriber" class='title-line'>
            <span>HAZTE TRIBER</span>
        </div>
        <div class="col-md-12 video">
        </div>
        <div style="clear: both;"></div>
        <br />
        <div class="haztetriber_title">
            ¿QUIERES SER TRIBER Y TRABAJAR CON NOSOTROS?
        </div>
        <br />
        <div class="haztetriber_description">
            Bueno… Triber ya eres, porque te gusta internet, porque te gusta ver y hacer vídeos, fotos y además subirlas, porque disfrutas de las redes sociales, y sobre todo, porque te lo pasas bien.
            <br /><br />
            Pues ya está, vente a Tribo porque buscamos gente  que nos envíe sus videos, cace noticias al vuelo, que controle las redes sociales y que le encante el mundo on line.
            <br /><br />
            Queremos sumar los mejores buscadores de contenidos, supporters del on line que sean fánaticos de internet. Bloggers, nativos digitales y profesionales, capaces de ver más allá del mainstreim, detectores de filones y capaces de generar tendencia y viralidad con sus búsquedas.
        </div>
        <div style="clear: both;"></div>
        <br /><br />

        <div class="well">
            <fieldset>
                <form method="post" action="<?=Url::site();?>" class="form-horizontal ajax" name="mainForm" id="mainForm" role="form" autocomplete="off" enctype="multipart/form-data">
                    <input type="hidden" name="app" id="app" value="login">
                    <input type="hidden" name="action" id="action" value="registerTribber">
                    <div class="form-group">
                        <label for="user" class="col-sm-offset-1 col-sm-3 control-label l-left"><img src="<?=Url::template("img/haztetriber/user.png");?>" />&nbsp;&nbsp;Usuario</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="username" name="username" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="passw" class="col-sm-offset-1 col-sm-3 control-label l-left"><img src="<?=Url::template("img/haztetriber/passw.png");?>" />&nbsp;&nbsp;Contraseña</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="password" name="password" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-offset-1 col-sm-3 control-label l-left"><img src="<?=Url::template("img/haztetriber/email.png");?>" />&nbsp;&nbsp;Email</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="email" name="email" />
                        </div>
                    </div>
                    <!-- Buttons -->
                    <div class="form-group">
                        <div class="col-sm-offset-1 col-sm-2 l-left">
                            <?=HTML::formButton("btn-tribo-grey", null, "Regístrate", array(
                                    "data-app" => "login",
                                    "data-action" => "registerTribber"
                                )
                            );?>
                        </div>
                        <div class="col-sm-9 l-right">
                            <span class="yareg">Si ya estás registrado, accede como usuario:</span>
                            <?=HTML::formLink("btn-tribo-blue", null, Url::site("login"), "Entrar");?>
                        </div>
                    </div>
                </form>
            </fieldset>
        </div>

        <div style="clear: both;"></div>
        <br /><br />
        <div class="haztetriber_contacta">
        También puesdes ponerte en contacto con nosotros en:
        <br />
        <a href="mailto:info@tribo.tv">info@tribo.tv</a>
        </div>

    </div>

</div>
