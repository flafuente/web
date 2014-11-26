<?php defined('_EXE') or die('Restricted access'); ?>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=places"></script>

<?php $user = Registry::getUser();?>
<div class='col-md-12 serie_info'>
    <div class="square-info">
        <div class="grey">
            <?=Language::translate("VIEW_PERFIL_EDIT_TITLE");?>
        </div>
        <div class="canalesd">
            <form method="post" action="<?=Url::site();?>" class="form-horizontal ajax" name="mainForm" id="mainForm" role="form" autocomplete="off" enctype="multipart/form-data">
                <input type="hidden" name="app" id="app" value="perfil">
                <input type="hidden" name="action" id="action" value="save">
                <div class="row">
                    <div class="profile-picture-sq">
                        <!-- sin Pulsar -->
                        <div class='col-md-3' style="text-align: center;">
                            <!-- Foto -->
                            <img src="<?=$user->getFotoUrl();?>">
                            <div class="btn btn-grey" id="foto_upl_prof"><?=Language::translate("VIEW_PERFIL_EDIT_FOTO");?></div>
                        </div>
                    </div>
                    <div class='col-md-9' style="padding-bottom: 0px; margin-top: -25px;">
                        <div class="col-sm-12" style="padding-bottom: 0px;">
                            <label for="nombre" class="control-label" style="margin-top: 10px;"><?=Language::translate("VIEW_PERFIL_EDIT_NOMBRE");?> <span class="yareg">- <?=Language::translate("VIEW_PERFIL_EDIT_NOMBRE_DETAILS")?></span></label>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="<?=Language::translate("VIEW_PERFIL_EDIT_NOMBRE_PLACEHOLDER");?>" value="<?=Helper::sanitize($user->nombre)?>">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="<?=Language::translate("VIEW_PERFIL_EDIT_APELLIDOS_PLACEHOLDER");?>" value="<?=Helper::sanitize($user->apellidos)?>">
                        </div>
                        <div class="col-sm-12">
                            <label for="email" class="control-label" style="margin-top: 10px;"><?=Language::translate("VIEW_PERFIL_EDIT_EMAIL")?> <span class="yareg">- <?=Language::translate("VIEW_PERFIL_EDIT_EMAIL_DETAILS")?></span></label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="<?=Language::translate("VIEW_PERFIL_EDIT_EMAIL_PLACEHOLDER")?>" value="<?=Helper::sanitize($user->email)?>">
                        </div>
                    </div>
                    <div class="profile-picture-sq uppic">
                        <div class='col-md-3' style="text-align: center;">
                            <!-- Foto -->
                            <img src="<?=$user->getFotoUrl();?>">
                            <div class="aclose btn btn-grey" id="foto_upl_prof"><?=Language::translate("VIEW_PERFIL_EDIT_FOTO");?></div>
                        </div>
                        <div class='col-md-6' style="min-height: 170px;">
                            <div style="margin-top: 20px; padding: 0px !important; margin-left: 10px;">
                            <i class="fa fa-long-arrow-right btnazul btnazul-ico" style="top: 45px; color: #FFFFFF;"></i>
                                &nbsp;&nbsp;
                                <input id="fotdis" name="foto" type="file" value="<?=Language::translate("VIEW_PERFIL_EDIT_FOTO_BTN");?>" class="btnazul fotdis foto" style="top: 45px;" />
                            <div style="clear: both;"></div>
                            <?php /* <i class="fa fa-long-arrow-right btnazul btnazul-ico" style="top: 45px; color: #FFFFFF;"></i>
                                &nbsp;&nbsp;
                                <input name="" type="file" value="Tómate una foto con tu dispositivo" class="btnazul fotord foto" style="top: 45px;" /> */ ?>
                            </div>
                        </div>
                        <div class='col-md-3' style="min-height: 170px;">
                            <div class="previsualizacion" id="fotoPreviewHelp">
                                <?=Language::translate("VIEW_PERFIL_EDIT_FOTO_PREVIEW");?>
                            </div>
                            <img src="" class="previsualizacion" id="fotoPreview" style="display:none">
                        </div>
                    </div>

                    <!-- <div style="clear: both;"></div> -->

                    <?php echo HTML::showInput(Url::template("img/haztetriber/user.png"), Language::translate("VIEW_PERFIL_EDIT_USERNAME"), "username", Helper::sanitize($user->username), Language::translate("VIEW_PERFIL_EDIT_USERNAME")); ?>
                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="col-sm-3 control-label l-left" style="margin-top: 10px;">
                            <img src="<?=Url::template("img/haztetriber/passw.png");?>" />&nbsp;&nbsp;<?=Language::translate("VIEW_PERFIL_EDIT_PASSWORD")?>
                        </label>
                        <div class="col-sm-9">
                            <a class="btn btn-primary" href="#" id="seepasswd"><?=Language::translate("VIEW_PERFIL_EDIT_CHANGE_PASSWORD")?></a>
                            <div class="form-change-pass">
                                <?php
                                echo HTML::showInput("", Language::translate("VIEW_PERFIL_EDIT_OLD_PASSWORD"), "passwordCurrent", "", "", "password", true, 5);
                                echo HTML::showInput("", Language::translate("VIEW_PERFIL_EDIT_NEW_PASSWORD"), "password", "", "", "password", true, 5);
                                echo HTML::showInput("", Language::translate("VIEW_PERFIL_EDIT_CONFIRM_PASSWORD"), "password2", "", "", "password", true, 5);
                                ?>
                                <div class="col-sm-offset-5 col-sm-7">
                                    <?=HTML::formButton("btn btn-primary col-md-5", null, Language::translate("BTN_APLY"), array(
                                        "data-app" => "perfil",
                                        "data-action" => "save"
                                    ));?>
                                    <div class="col-sm-2"></div>
                                    <a href="#" class="aclose btn btn-grey col-md-5" style="color: #FFF; background-color: #9b9b9b">
                                        <?=Language::translate("BTN_CANCEL")?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    echo HTML::showInput(Url::template("img/haztetriber/loc.png"), Language::translate("VIEW_PERFIL_EDIT_LOCALIZACION"), "ubicacion", Helper::sanitize($user->ubicacion), Language::translate("VIEW_PERFIL_EDIT_LOCALIZACION_PLACEHOLDER"));
                    echo HTML::showInput(Url::template("img/haztetriber/url.png"), Language::translate("VIEW_PERFIL_EDIT_SITIOS"), "sitios", Helper::sanitize($user->sitios), Language::translate("VIEW_PERFIL_EDIT_SITIOS_PLACEHOLDER"), array("id" => "sitios"));
                    echo HTML::showInput(Url::template("img/haztetriber/bio.png"), Language::translate("VIEW_PERFIL_EDIT_BIOGRAFIA"), "biografia", Helper::sanitize($user->biografia), Language::translate("VIEW_PERFIL_EDIT_BIOGRAFIA_PLACEHOLDER"), "textarea");
                    echo HTML::showInput(Url::template("img/haztetriber/bio.png"), Language::translate("VIEW_PERFIL_EDIT_INTERESES"), "intereses", Helper::sanitize($user->intereses));
                    echo HTML::showInput(Url::template("img/haztetriber/telefono.png"), Language::translate("VIEW_PERFIL_EDIT_TELEFONO"), "telefono", Helper::sanitize($user->telefono), Language::translate("VIEW_PERFIL_EDIT_TELEFONO_PLACEHOLDER"));

                    /*He comentado esto, que no viene en el diseño!*/
                    ?>
                    <!-- Sexo
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Sexo
                        </label>
                        <div class="col-sm-10">
                            <?php $s = array();?>
                            <?php $s[$user->sexo]; ?>
                            <input type="radio" goup="sexo" name="sexo" id="sexo1" value="1" <?=$s[1]?>>
                            Femenino
                            <input type="radio" goup="sexo" name="sexo" id="sexo2" value="2" <?=$s[2]?>>
                            Masculino
                        </div>
                    </div>
                    -->

                    <!-- Cumpleaños
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Cumpleaños
                        </label>
                        <div class="col-sm-10">
                            <input type="date" id="fechaNacimiento" name="fechaNacimiento" class="form-control" value="<?=date("m/d/Y", strtotime($user->fechaNacimiento));?>">
                        </div>
                    </div>
                    -->

                    <!-- Formación y empleo
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Formación y empleo
                        </label>
                        <div class="col-sm-10">
                            <input type="text" id="trabajo" name="trabajo" class="form-control" placeholder="¿Dónde has trabajado?" value="<?=Helper::sanitize($user->trabajo);?>">
                            <br>
                            <input type="text" id="estudios" name="estudios" class="form-control" placeholder="¿Dónde has estudiado?" value="<?=Helper::sanitize($user->estudios);?>">
                        </div>
                    </div>
                    -->

                    <!-- Buttons -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <?=HTML::formButton("btn btn-primary col-md-12", "ok", Language::translate("BTN_SAVE_CHANGES"), array(
                                    "data-app" => "perfil",
                                    "data-action" => "save"
                                )
                            );?>
                        </div>
                        <div class="col-sm-offset-3 col-sm-9">
                            <?=HTML::formButton("btn btn-default col-md-5", null, Language::translate("BTN_SAVE_DELETE_ACCOUNT"));?>
                            <div class="col-sm-2"></div>
                            <?=HTML::formButton("btn btn-grey col-md-5", "cog", '   '.Language::translate("BTN_CONFIG"), Array("style" => "color: #FFF; background-color: #9b9b9b;"), "fa");?>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>

<script>
    /* Gooogle Maps Autocomplete */
    $("#ubicacion").placepicker();

    $("#sitios").select2({
        tags:[],
        tokenSeparators: [",", " "]
    });
    $(".foto").change(function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#fotoPreview').attr('src', e.target.result).show();
                $("#fotoPreviewHelp").hide();
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>
