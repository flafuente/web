<?php defined('_EXE') or die('Restricted access'); ?>

<div class='col-md-12'>
    <div class='video-info' style="padding: 5px;">

        <div id="haztetriber" class='title-line'>
            <span>HAZTE TRIBER</span>
        </div>

        <div class="col-md-12 video">
            <?=HTML::wistiaPlayer("sy58tqt7xz", "558", "314");?>
        </div>

        <div style="clear: both;"></div>
        <br />

        <?php $articulo = new Articulo(1); ?>
        <?php echo $articulo->texto; ?>

        <div style="clear: both;"></div>
        <br /><br />

        <div class="well">
            <fieldset>
                <form method="post" action="<?=Url::site();?>" class="form-horizontal ajax" name="mainForm" id="mainForm" role="form" autocomplete="off" enctype="multipart/form-data">
                    <input type="hidden" name="app" id="app" value="login">
                    <input type="hidden" name="action" id="action" value="registerTriber">
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
                                    "data-action" => "registerTriber"
                                )
                            );?>
                        </div>
                        <div class="col-sm-9 l-right">
                            <span class="yareg">Si ya estás registrado, accede como usuario:</span>
                            <?=HTML::formLink("btn-tribo-blue", null, Url::site("?a=true"), "Entrar");?>
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
