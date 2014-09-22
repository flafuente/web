<?php defined('_EXE') or die('Restricted access');

?>
<div class='col-md-12 serie_info'>
    <div class="col-md-12 video">
        <?php HTML::wistiaPlayer("026x634bnv", "558", "314"); ?>
    </div>
    <div class="video-info">
        <div class="col-md-12 vd-ruta">Pruebas de emisión</div>
        <div class="col-md-8">
            <div class="vd-codigo" style="font-size: 14px; letter-spacing: -1px;">CAPITULO 0 | </div><div class="vd-capitulo" style="font-size: 15px;">Prueba</div>
        </div>
        <div class="col-md-4">
            <div class="sq_num">0 <i class="fa fa-heart-o"></i>
            </div>
        </div>
        <div class="col-md-12">
            <div class="vd-temporada">TEMPORADA 0</div>
        </div>
        <div class="col-md-12 video-desc">
            Emisión en pruebas.
            <br /><br />
            Pruebas.
            <br />
            <div class='col-md-6 epi_button'>
                <a href="<?=Url::site("/");?>">site programa
                <strong>|</strong>
                todos los capitulos</a>
            </div>
            <div class="col-md-6 ver-todas-web" style="margin-top: 30px;">
                Pruebas&nbsp;&nbsp;<a href="<?=Url::site("/");?>"><div class="circulo-azul">+</div></a>
            </div>
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
