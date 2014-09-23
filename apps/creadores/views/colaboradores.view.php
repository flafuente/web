<?php defined('_EXE') or die('Restricted access'); ?>

<div class='col-md-12 serie_info'>
    <div class="col-md-12 video">
        <?php HTML::wistiaPlayer("188kbnzoh2", "558", "314"); ?>
    </div>
    <div style="clear: both;"></div>
    <br />

    <?php $articulo = new Articulo(2); ?>
    <?php echo $articulo->texto; ?>

    <div style="clear: both;"></div>
    <br /><br />

    <div class="well">
        <div class="well_title">
            ¿Tienes alguna consulta o algo que enseñarnos?
        </div>
        <fieldset>
            <form class="form-horizontal ajax" role="form" method="post" name="mainForm" id="mainForm" action="<?=Url::site("contacto/enviar");?>">
                <div class="form-group">
                    <label for="user" class="col-sm-offset-1 col-sm-3 control-label l-left"><img src="<?=Url::template("img/haztetriber/user.png");?>" />&nbsp;&nbsp;Nombre</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" />
                    </div>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-offset-1 col-sm-3 control-label l-left"><img src="<?=Url::template("img/haztetriber/email.png");?>" />&nbsp;&nbsp;Email</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-offset-1 col-sm-3 control-label l-left"><img src="<?=Url::template("img/haztetriber/telefono.png");?>" />&nbsp;&nbsp;Teléfono</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-offset-1 col-sm-3 control-label l-left"><img src="<?=Url::template("img/haztetriber/mensaje.png");?>" />&nbsp;&nbsp;Mensaje</label>
                    <div class="col-sm-8">
                        <textarea id="mensaje" name="mensaje" placeholder="Mensaje" style="width: 100%; min-height: 100px;"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-offset-1 col-sm-3 control-label l-left"><img src="<?=Url::template("img/haztetriber/url.png");?>" />&nbsp;&nbsp;Url</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="url" name="url" placeholder="Url" />
                    </div>
                </div>
                <?php if (count($secciones)) { ?>
                    <!-- Sección -->
                    <div class="form-group">
                        <label for="email" class="col-sm-offset-1 col-sm-3 control-label l-left"><img src="<?=Url::template("img/haztetriber/seccion.png");?>" />&nbsp;&nbsp;Sección</label>
                        <div class="col-sm-8">
                            <?=HTML::select("seccionId", $secciones, null, null, null, array("display" => "nombre")); ?>
                        </div>
                    </div>
                <?php } ?>
                <!-- Buttons -->
                <div class="form-group">
                    <div class="col-sm-12 l-right">
                        <?=HTML::formButton("btn-tribo-blue", null, "Enviar", array(
                                "data-app" => "contacto",
                                "data-action" => "enviar"
                            )
                        );?>
                    </div>
                </div>
            </form>
        </fieldset>
    </div>
    <!--<div class="col-sm-12 l-right">
        <span class="yareg">O si ya eres colaborador, accede con tu cuenta:</span>
        <button class="btn btn-tribo-grey ladda-button" data-style="slide-left">Accede</button>
    </div>-->
</div>
