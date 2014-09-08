<?php defined('_EXE') or die('Restricted access'); ?>

<div class='col-md-12'>
    <div class="square-info">
        <div class="grey" style="margin-bottom: 0px;">
            PERFIL TRIBER
        </div>
        <div class="triber_info col-md-12">
            <div class='col-md-3'>
                <img src="<?=$triber->getFotoUrl();?>" style="width: 100px; height: 100px;" />
            </div>
            <div class='col-md-9 nopaddingT'>
                <h1 class="triber_name">
                    <?=Helper::sanitize($triber->nombre);?>
                </h1>
                <span class="triber_blue">MADRID</span> - Triber especializado en <span class="triber_blue">sociedad</span><br />
                <span class="triber_small">Triber desde 01/01/1970</span><br /><br />
                <span class="btn btn-tribo-grey" id="triber_masinfo">Datos de contacto</span>
            </div>
            <div class="clear: both;"></div>
        </div>
        <div class="clear: both;"></div>
        <div class="masinfo_triber col-md-12">
            <div class="col-md-6">
                <img src="<?=Url::template("img/perfilpublico/email.png");?>" /> Email: <span class="triber_blue">email@mail.com</span>
            </div>
            <div class="col-md-6">
                <img src="<?=Url::template("img/perfilpublico/telefono.png");?>" /> Telefono: +34 655 48 75 84
            </div>
        </div>
        <div class="triber_infowhite col-md-12">
            <h1><img src="<?=Url::template("img/perfilpublico/biografia.png");?>" /> Biografia</h1>
            <span>
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.
                <br /><br />
                In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.
            </span><br />
            <h1><img src="<?=Url::template("img/perfilpublico/sitiosweb.png");?>" /> Sus sitios web:
                <span><a href="#">Vimeo</a></span>
                <span><a href="#">Youtube</a></span>
                <span><a href="#">Web personal</a></span>
                <span><a href="#">Linkedin</a></span>
            </h1>

        </div>
    </div>

</div>
<div class="clear: both;"></div>
<div class='col-md-12 serie_info' style="margin-top: 20px;">
    <div class='video-info' style="padding: 5px;">
        <div class='title-line'>
            <span>NOTICIAS DE NOMBRE USER</span>
        </div>
        <?php
        for ($x=0; $x<5; $x++) {
            showTriberNews("Titulo ".$x, "Descripcion", "20:00");
        }
        ?>
    </div>
</div>
<div class="clear: both;"></div>
<div class='col-md-12' style="margin-top: 20px;">
    <div class='video-info' style="padding: 5px; float: left; width: 100%;">
        <div class='title-line'>
            <span>TRIBERS CON PERFIL SIMILAR A NOMBRE USER</span>
        </div>
        <?php
        for($x=0; $x<4; $x++)
            showTriberFace("http://dev.tribo.tv/files/images/programas/15405e82dbb918_GKOPJHINELMFQ.jpeg", "nombre triber", "#", "Valencia", rand(1, 68));
        ?>
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

<?php
function showTriberFace($imagen, $nombre, $enlace, $ciudad, $noticias)
{
    ?>
    <div class="similar_triber col-md-3">
        <img src="<?= $imagen; ?>" alt="<?= $nombre; ?>" title="<?= $nombre; ?>" />
        <div class="oversimilar">
            <a href="<?= $enlace; ?>">
                <div class="similar_name"><?= $nombre; ?></div>
                <div class="similar_city"><?= $ciudad; ?></div>
                <div class="similar_news"><?= $noticias; ?> noticias</div>
            </a>
        </div>
    </div>
    <?php
}
function showTriberNews($titulo, $descripcion, $duracion)
{
    $likes = rand(0, 1000);
    ?>
    <div class='col-md-6 square' style="border-bottom: 1px solid #CCC;">
        <a href="<?=Url::site("reproductor/capitulo/".$capitulo->id);?>">
            <img src="http://dev.tribo.tv/files/images/programas/15405e82dbb918_GKOPJHINELMFQ.jpeg" title="<?=Helper::sanitize($titulo); ?>" style="width: 250px; height: 100px;" />
        </a>
        <div class="rating">
            <?=HTML::showRate($likes, 1000);?>
        </div>
    </div>
    <div class='col-md-6 squaredesc'>
        <a  class="sqd_title" href="<?=Url::site("reproductor");?>">
            <?=Helper::sanitize($titulo); ?>
        </a>
        <div class="sqd_description" style="height: 55px;">
            <?=Helper::sanitize($descripcion); ?>
        </div>
        <span class="sqd_info">
            <?=Helper::sanitize($duracion); ?>
        </span>
    </div>
    <div style="clear: both;"></div>
    <?php
}
?>
