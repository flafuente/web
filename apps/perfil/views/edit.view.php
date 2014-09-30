<?php defined('_EXE') or die('Restricted access'); ?>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=places"></script>

<?php $user = Registry::getUser();?>
<div class='col-md-12 serie_info'>
    <div class="square-info">
        <div class="grey">
            MI PERFIL
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
                            <div class="btn btn-grey" id="foto_upl_prof">Cambiar foto</div>
                        </div>
                    </div>
                    <div class='col-md-9' style="padding-bottom: 0px; margin-top: -25px;">
                        <div class="col-sm-12" style="padding-bottom: 0px;">
                            <label for="nombre" class="control-label" style="margin-top: 10px;">Nombre <span class="yareg">- Lo utilizaremos como firma de tus videos</span></label>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Tu nombre" value="<?=Helper::sanitize($user->nombre)?>">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Tus apellidos" value="<?=Helper::sanitize($user->apellidos)?>">
                        </div>
                        <div class="col-sm-12">
                            <label for="email" class="control-label" style="margin-top: 10px;">Email <span class="yareg">- Lo utilizaremos para contactar contigo</span></label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Tu email" value="<?=Helper::sanitize($user->email)?>">
                        </div>
                    </div>
                    <div class="profile-picture-sq uppic">
                        <div class='col-md-3' style="text-align: center;">
                            <!-- Foto -->
                            <img src="<?=$user->getFotoUrl();?>">
                            <div class="aclose btn btn-grey" id="foto_upl_prof">Cambiar foto</div>
                        </div>
                        <div class='col-md-6' style="min-height: 170px;">
                            <div style="margin-top: 20px; padding: 0px !important; margin-left: 10px;">
                            <i class="fa fa-long-arrow-right btnazul btnazul-ico" style="top: 45px; color: #FFFFFF;"></i>
                                &nbsp;&nbsp;
                                <input id="fotdis" name="foto" type="file" value="Selecciona una foto de tu dispositivo" class="btnazul fotdis foto" style="top: 45px;" />
                            <div style="clear: both;"></div>
                            <?php /* <i class="fa fa-long-arrow-right btnazul btnazul-ico" style="top: 45px; color: #FFFFFF;"></i>
                                &nbsp;&nbsp;
                                <input name="" type="file" value="Tómate una foto con tu dispositivo" class="btnazul fotord foto" style="top: 45px;" /> */ ?>
                            </div>
                        </div>
                        <div class='col-md-3' style="min-height: 170px;">
                            <div class="previsualizacion" id="fotoPreviewHelp">
                                Aquí previsualizarás la foto que cargues.
                            </div>
                            <img src="" class="previsualizacion" id="fotoPreview" style="display:none">
                        </div>
                    </div>

                    <!-- <div style="clear: both;"></div> -->

                    <?php echo HTML::showInput(Url::template("img/haztetriber/user.png"), "Usuario", "username", Helper::sanitize($user->username), "Introduce aquí tu usuario"); ?>
                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="col-sm-3 control-label l-left" style="margin-top: 10px;">
                            <img src="<?=Url::template("img/haztetriber/passw.png");?>" />&nbsp;&nbsp;Contraseña
                        </label>
                        <div class="col-sm-9">
                            <a class="btn btn-primary" href="#" id="seepasswd">Cambiar contraseña</a>
                            <div class="form-change-pass">
                                <?php
                                echo HTML::showInput("", "Contraseña antigua", "passwordCurrent", "", "", "password", true, 5);
                                echo HTML::showInput("", "Tu nueva contraseña", "password", "", "", "password", true, 5);
                                echo HTML::showInput("", "Confirma la contraseña", "password2", "", "", "password", true, 5);
                                ?>
                                <div class="col-sm-offset-5 col-sm-7">
                                    <?=HTML::formButton("btn btn-primary col-md-5", null, "Aplicar", array(
                                        "data-app" => "perfil",
                                        "data-action" => "save"
                                    ));?>
                                    <div class="col-sm-2"></div>
                                    <a href="#" class="aclose btn btn-grey col-md-5" style="color: #FFF; background-color: #9b9b9b">
                                        Cancelar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    echo HTML::showInput(Url::template("img/haztetriber/loc.png"), "Localización", "ubicacion", Helper::sanitize($user->ubicacion), "Pon la ciudad en la que resides actualmente...");
                    echo HTML::showInput(Url::template("img/haztetriber/url.png"), "Tus sitios", "sitios", Helper::sanitize($user->sitios), "Enlaza a tu Youtube, Vimeo, web personal...", array("id" => "sitios"));
                    echo HTML::showInput(Url::template("img/haztetriber/bio.png"), "Biografía", "biografia", Helper::sanitize($user->biografia), "Escribe un resumen de tu trayectoria profesional...", "textarea");
                    echo HTML::showInput(Url::template("img/haztetriber/bio.png"), "Intereses", "intereses", Helper::sanitize($user->intereses));
                    echo HTML::showInput(Url::template("img/haztetriber/telefono.png"), "Teléfono", "telefono", Helper::sanitize($user->telefono), "Por si te tenemos que contactar rapidamente");

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
                            <?=HTML::formButton("btn btn-primary col-md-12", "ok", " Guardar cambios", array(
                                    "data-app" => "perfil",
                                    "data-action" => "save"
                                )
                            );?>
                        </div>
                        <div class="col-sm-offset-3 col-sm-9">
                            <?=HTML::formButton("btn btn-default col-md-5", null, "Eliminar cuenta");?>
                            <div class="col-sm-2"></div>
                            <?=HTML::formButton("btn btn-grey col-md-5", "cog", '   Configuracion', Array("style" => "color: #FFF; background-color: #9b9b9b;"), "fa");?>
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
