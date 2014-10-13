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
            <?=Language::translate("VIEW_CREADORES_COLABORADORES_TITLE_CONSULTA")?>
        </div>
        <fieldset>
            <form class="form-horizontal ajax" role="form" method="post" name="mainForm" id="mainForm" action="<?=Url::site("contacto/enviar");?>">
                <div class="form-group">
                    <label for="user" class="col-sm-offset-1 col-sm-3 control-label l-left"><img src="<?=Url::template("img/haztetriber/user.png");?>" />&nbsp;&nbsp;<?=Language::translate("VIEW_CREADORES_COLABORADORES_FIELD_NOMBRE")?></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="<?=Language::translate("VIEW_CREADORES_COLABORADORES_FIELD_NOMBRE")?>" />
                    </div>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="<?=Language::translate("VIEW_CREADORES_COLABORADORES_FIELD_APELLIDOS")?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-offset-1 col-sm-3 control-label l-left"><img src="<?=Url::template("img/haztetriber/email.png");?>" />&nbsp;&nbsp;<?=Language::translate("VIEW_CREADORES_COLABORADORES_FIELD_EMAIL")?></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="email" name="email" placeholder="<?=Language::translate("VIEW_CREADORES_COLABORADORES_FIELD_EMAIL")?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-offset-1 col-sm-3 control-label l-left"><img src="<?=Url::template("img/haztetriber/telefono.png");?>" />&nbsp;&nbsp;<?=Language::translate("VIEW_CREADORES_COLABORADORES_FIELD_TELEFONO")?></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="telefono" name="telefono" placeholder="<?=Language::translate("VIEW_CREADORES_COLABORADORES_FIELD_TELEFONO")?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-offset-1 col-sm-3 control-label l-left"><img src="<?=Url::template("img/haztetriber/mensaje.png");?>" />&nbsp;&nbsp;<?=Language::translate("VIEW_CREADORES_COLABORADORES_FIELD_MENSAJE")?></label>
                    <div class="col-sm-8">
                        <textarea id="mensaje" name="mensaje" placeholder="Mensaje" style="width: 100%; min-height: 100px;"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-offset-1 col-sm-3 control-label l-left"><img src="<?=Url::template("img/haztetriber/url.png");?>" />&nbsp;&nbsp;<?=Language::translate("VIEW_CREADORES_COLABORADORES_FIELD_URL")?></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="url" name="url" placeholder="<?=Language::translate("VIEW_CREADORES_COLABORADORES_FIELD_URL")?>" />
                    </div>
                </div>
                <?php if (count($secciones)) { ?>
                    <!-- Sección -->
                    <div class="form-group">
                        <label for="email" class="col-sm-offset-1 col-sm-3 control-label l-left"><img src="<?=Url::template("img/haztetriber/seccion.png");?>" />&nbsp;&nbsp;<?=Language::translate("VIEW_CREADORES_COLABORADORES_FIELD_SECCION")?></label>
                        <div class="col-sm-8">
                            <?=HTML::select("seccionId", $secciones, null, null, null, array("display" => "nombre")); ?>
                        </div>
                    </div>
                <?php } ?>
                <!-- Buttons -->
                <div class="form-group">
                    <div class="col-sm-12 l-right">
                        <?=HTML::formButton("btn-tribo-blue", null, Language::translate("BTN_SUBMIT"), array(
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
