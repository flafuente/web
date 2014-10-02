<?php defined('_EXE') or die('Restricted access');

?>
<div class='col-md-12 serie_info'>
    <div class="col-md-12 video">
        <script id="overon_main_script" type="text/javascript" src="http://overonocc.cdn.customers.overon.es/player/environment.js"></script>
        <div id='video_player'></div>
        <script>
            $(document).ready(function () {
                showPlayer();
            });
            $( window ).resize(function () {
                showPlayer();
            });
            function showPlayer()
            {
                if ($(window).width() < 600) {
                    wdt = ($(window).width()-3);
                    hgt = (($(window).width()-4)/1.4);
                } else {
                    wdt = 570;
                    hgt = 410;
                }
                OVERON_Player.init({
                    width: wdt,
                    height: hgt,
                    container: 'video_player',
                    stream: 'http://overon-apple-live.adaptive.level3.net/apple/overon/channel06/index.m3u8'
                });
            }
        </script>
    </div>
    <div class="video-info">
        <div class="col-md-12 vd-ruta">Tribo en directo</div>
        <div class="col-md-8">
            <!--<div class="vd-codigo" style="font-size: 14px; letter-spacing: -1px;">Tribo en </div><div class="vd-capitulo" style="font-size: 15px;">directo</div>-->
        </div>
        <div class="col-md-4">
            <div class="sq_num">0 <i class="fa fa-heart-o"></i>
            </div>
        </div>
        <div class="col-md-12">
            <div class="vd-temporada"></div>
        </div>
        <div class="col-md-12 video-desc">
            Emisión en directo.

            <br />
            <div class='col-md-6 epi_button'>
                <a href="<?=Url::site("/");?>">site programa
                <strong>|</strong>
                todos los capitulos</a>
            </div>
            <!--<div class="col-md-6 ver-todas-web" style="margin-top: 30px;">
                Pruebas&nbsp;&nbsp;<a href="<?=Url::site("/");?>"><div class="circulo-azul">+</div></a>
            </div>-->
        </div>
        <div style="clear: both;"></div>
    </div>

<?php
   //Listado de proximas series
/*Extraer de BBDD la parrilla y meterlo en el controller, llamarlo e imprimirlo con el module de capitulo-mini*/
    if (count($proximos)) {
    ?>
    <br /><br />
    <div class='title-line'>
        <span>DESPUÉS EN TRIBO</span>
    </div>
    <?php
        foreach ($proximos as $proximo) {
            $controller->setData("proximo", $proximo);
            echo $controller->view("modules.capitulo-mini", "programas");
        }
    ?>
    <div class='col-md-6'></div>
    <div class="col-md-6 ver-todas-web" style="margin-top: 30px;">
        Ver parrilla completa&nbsp;&nbsp;<a href="<?=Url::site("parrillas");?>"><div class="circulo-azul">+</div></a>
    </div>
    <?php
    }
?>

</div>
