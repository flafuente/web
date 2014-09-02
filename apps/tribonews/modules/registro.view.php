<?php defined('_EXE') or die('Restricted access'); ?>

<div class='col-md-12'>
    <div class='video-info' style="padding: 5px;">
        <div id="haztetriber" class='title-line'>
            <span>HAZTE TRIBER</span>
        </div>
        <div class="col-md-12 video">
		
			<div id="wistia_sy58tqt7xz" class="wistia_embed" style="width:558px;height:314px;"> </div>
			<script charset="ISO-8859-1" src="//fast.wistia.com/assets/external/E-v1.js"></script>
			<script>
			wistiaEmbed = Wistia.embed("sy58tqt7xz");
			</script>
		
        </div>
        <div style="clear: both;"></div>
        <br />
        <div class="haztetriber_title">
            ¿QUIERES SER TRIBER Y TRABAJAR CON NOSOTROS?
        </div>
        <br />
        <div class="haztetriber_description">
            Los informativos de Tribo son diferentes, singulares y con mucha personalidad.
            <br /><br />
            Tanto es así, que estarán hechos por contenidos grabados, producidos y enviados por los propios Tribers.
            <br /><br />
            Los Tribers no son sólo periodistas, son testigos de la realidad. Se trata de ciudadanos con inquietudes, capaces de enviarnos sus videos desde el lugar de la noticia.
			<br /><br />
			La realidad y la inmediatez en estado puro. Será la red de Tribers, los que nutran libremente con sus piezas, los contenidos informativos de la cadena. Sin consignas, ni sesgos.
			<br /><br />
			Todo esto en un informativo con secciones libres, sin tiempos fijos, ni temas prefijados, y siempre dejando un buen sabor de boca al espectador con una noticia positiva.
			<br /><br />
			<b>BE TRIBER</b>
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
