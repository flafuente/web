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
                <span class="triber_blue"><?=Helper::sanitize($triber->ubicacion);?></span> - Triber especializado en <span class="triber_blue"><?=Helper::sanitize($triber->categorias);?></span><br />
                <span class="triber_small">Triber desde <?=date("d/m/Y", strtotime(Helper::sanitize($triber->dateInsert)));?></span><br /><br />
                <span class="btn btn-tribo-grey" id="triber_masinfo">Datos de contacto</span>
            </div>
            <div class="clear: both;"></div>
        </div>
        <div class="clear: both;"></div>
        <div class="masinfo_triber col-md-12">
            <div class="col-md-6">
                <img src="<?=Url::template("img/perfilpublico/email.png");?>" /> Email: <span class="triber_blue"><?=Helper::sanitize($triber->email);?></span>
            </div>
            <div class="col-md-6">
                <img src="<?=Url::template("img/perfilpublico/telefono.png");?>" /> Telefono: <?=Helper::sanitize($triber->telefono);?>
            </div>
        </div>
        <div class="triber_infowhite col-md-12">
            <h1><img src="<?=Url::template("img/perfilpublico/biografia.png");?>" /> Biografia</h1>
            <span>
               <?=Helper::sanitize($triber->biografia);?>
            </span><br />
            <h1><img src="<?=Url::template("img/perfilpublico/sitiosweb.png");?>" /> Sus sitios web:
                <?php
                $sts = explode(",", $triber->sitios);
                for($x=0; $x<count($sts); $x++){
                    $vari = $sts[$x];
                    if(!strpos($sts[$x], "http")) $vari = "http://".$sts[$x];
                    ?>
                    <span><a href="<?=Helper::sanitize($vari);?>" target="_blank"><?=Helper::sanitize($sts[$x]);?></a></span>
                    <?php
                }
                ?>
            </h1>

        </div>
    </div>

</div>
<div class="clear: both;"></div>
<div class='col-md-12 serie_info' style="margin-top: 20px;">
    <div class='video-info' style="padding: 5px;">
        <div class='title-line'>
            <span>NOTICIAS DE <?=Helper::sanitize($triber->nombre);?></span>
        </div>
        <?php
        foreach($videos as $video) {
            showTriberNews($video->thumbnail, $video->titulo, $video->descripcion, rand(0,60).":".rand(0,60));
        }
        ?>
    </div>
</div>
<div class="clear: both;"></div>
<div class='col-md-12' style="margin-top: 20px;">
    <div class='video-info' style="padding: 5px; float: left; width: 100%;">
        <div class='title-line'>
            <span>TRIBERS CON PERFIL SIMILAR A <?=Helper::sanitize($triber->nombre);?></span>
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
function showTriberNews($thum, $titulo, $descripcion, $duracion)
{
    $likes = rand(0, 1000);
    ?>
    <div class='col-md-6 square' style="border-bottom: 1px solid #CCC;">
        <a href="<?=Url::site("reproductor/capitulo/".$capitulo->id);?>">
            <img src="<?=$thum; ?>" title="<?=Helper::sanitize($titulo); ?>" style="width: 250px;" />
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
