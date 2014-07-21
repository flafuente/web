<?php defined('_EXE') or die('Restricted access'); ?>

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
                        <div class='col-md-3'>
                            <!-- Foto -->
                            <img src="<?=$user->getFotoUrl();?>">
                            <input type="file" id="foto" name="foto" accept="image/*" value="Cambiar foto">
                        </div>
                        <div class='col-md-6'>
                            <div class="btnazul" style="margin-top: 30px;">Selecciona una foto de tu dispositivo</div>
                            <div class="btnazul">Tómate una foto con tu dispositivo</div>
                        </div>
                        <div class='col-md-3'>
                            <div class="previsualizacion" id="fotoPreviewHelp">
                                Aquí previsualizarás la foto que cargues.
                            </div>
                            <img src="" class="previsualizacion" id="fotoPreview" style="display:none">
                        </div>
                        <div style="clear: both;"></div>
                    </div>

                    <?php HTML::showInput(Url::template("img/haztetriber/user.png"), "Usuario", "username", Helper::sanitize($user->username), "Introduce aquí tu usuario"); ?>
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
                                    <a href="#" class="btn btn-grey col-md-5" style="color: #FFF; background-color: #9b9b9b">
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
                            <?=HTML::formButton("btn btn-primary col-md-12", "ok", "Guardar cambios", array(
                                    "data-app" => "perfil",
                                    "data-action" => "save"
                                )
                            );?>
                        </div>
                        <div class="col-sm-offset-3 col-sm-9">
                            <?=HTML::formButton("btn btn-default col-md-5", null, "Eliminar cuenta");?>
                            <div class="col-sm-2"></div>
                            <?=HTML::formButton("btn btn-grey col-md-5", null, "Configuracion", Array("style" => "color: #FFF; background-color: #9b9b9b;"));?>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>

<script>
    $("#sitios").select2({
        tags:[],
        tokenSeparators: [",", " "]
    });
    $("#foto").change(function () {
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
