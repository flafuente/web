<?php defined('_EXE') or die('Restricted access'); ?>

<div class='col-md-12'>
    <div class="square-info">
        <div class="grey" style="margin-bottom: 0px;">
            PERFIL TRIBER
        </div>
        <div class="triber_info col-md-12">

            <!-- Foto -->
            <div class='col-md-3'>
                <img src="<?=$triber->getFotoUrl();?>" style="width: 100px; height: 100px;" />
            </div>

            <div class='col-md-9 nopaddingT'>

                <!-- Nombre -->
                <h1 class="triber_name">
                    <?=Helper::sanitize($triber->nombre);?>
                </h1>

                <!-- Ubicación -->
                <span class="triber_blue">
                    <?=Helper::sanitize($triber->ubicacion);?>
                </span>

                <?php if ($especialidad) { ?>
                    <!-- Especialidad -->
                    - Triber especializado en
                    <span class="triber_blue">
                        <?=Helper::sanitize($especialidad->nombre);?>
                    </span>
                <?php } ?>
                <br />

                <!-- Fecha -->
                <span class="triber_small">
                    Triber desde <?=date("d/m/Y", strtotime(Helper::sanitize($triber->dateInsert)));?>
                </span>
                <br /><br />

                <span class="btn btn-tribo-grey" id="triber_masinfo">Datos de contacto</span>

            </div>
            <div class="clear: both;"></div>
        </div>
        <div class="clear: both;"></div>

        <div class="masinfo_triber col-md-12">

            <!-- Email -->
            <div class="col-md-6">
                <img src="<?=Url::template("img/perfilpublico/email.png");?>" />
                Email:
                <span class="triber_blue">
                    <?=Helper::sanitize($triber->email);?>
                </span>
            </div>

            <!-- Teléfono -->
            <?php if ($triber->telefono) { ?>
                <div class="col-md-6">
                    <img src="<?=Url::template("img/perfilpublico/telefono.png");?>" />
                    Teléfono:
                    <?=Helper::sanitize($triber->telefono);?>
                </div>
            <?php } ?>

        </div>

        <div class="triber_infowhite col-md-12">

            <!-- Biografía -->
            <?php if ($triber->biografia) { ?>
                <h1>
                    <img src="<?=Url::template("img/perfilpublico/biografia.png");?>" />
                    Biografía
                </h1>
                <span>
                   <?=Helper::sanitize($triber->biografia);?>
                </span><br />
            <?php } ?>

            <!-- Sitios web -->
            <?php $sitios = explode(",", $triber->sitios); ?>
            <?php if (!empty($sitios)) { ?>
                <h1>
                    <img src="<?=Url::template("img/perfilpublico/sitiosweb.png");?>" />
                    Sus sitios web:
                    <?php foreach ($sitios as $sitio) { ?>
                        <?php if ($sitio) { ?>
                            <?php if(!strstr($sitio, "http")) $sitio = "http://".$sitio; ?>
                            <span>
                                <a href="<?=Helper::sanitize($sitio);?>" target="_blank">
                                    <?=Helper::sanitize($sitio);?>
                                </a>
                            </span>
                        <?php } ?>
                    <?php } ?>
                </h1>
            <?php } ?>

        </div>
    </div>

</div>
<div class="clear: both;"></div>

<!-- Notícias -->
<?php if (!empty($videos)) { ?>
    <div class='col-md-12 serie_info' style="margin-top: 20px;">
        <div class='video-info' style="padding: 5px;">
            <div class='title-line'>
                <span>NOTICIAS DE <?=Helper::sanitize($triber->nombre);?></span>
            </div>
            <?php foreach ($videos as $video) { ?>
                <?php $controller->setData("video", $video); ?>
                <?=$controller->view("modules.video-mini", "tribonews");?>
            <?php } ?>
        </div>
    </div>
    <div class="clear: both;"></div>

    <!-- Tribers relacionados -->
    <?php if (!empty($tribers)) { ?>
        <div class='col-md-12' style="margin-top: 20px;">
            <div class='video-info' style="padding: 5px; float: left; width: 100%;">
                <div class='title-line'>
                    <span>TRIBERS CON PERFIL SIMILAR A <?=Helper::sanitize($triber->nombre);?></span>
                </div>
                <?php foreach ($tribers as $triber) { ?>
                    <?php $controller->setData("user", $triber); ?>
                    <?=$controller->view("modules.video-mini", "tribonews");?>
                <?php } ?>
            </div>
            <div class="clear: both;"></div>
        </div>
        <script>
            $( document ).ready(function () {
                $(".similar_triber").hover(
                    function () {
                        //$(".oversimilar").css("display", "none");
                        $(this).children(".oversimilar").css("display", "inline");
                    },
                    function () {
                        $(this).children(".oversimilar").css("display", "none");
                    }
                );
            });
        </script>
    <?php } ?>

<?php } ?>
