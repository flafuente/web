<?php defined('_EXE') or die('Restricted access');

?>
<div class='col-md-12 serie_info'>
    <div class="col-md-12 video">
    </div>
    <div class="video-info">
        <div class="col-md-12 vd-ruta">Malviviendo</div>
        <div class="col-md-8">
            <div class="vd-codigo" style="font-size: 14px; letter-spacing: -1px;">CAPITULO 7 | </div><div class="vd-capitulo" style="font-size: 15px;">RESCATE EN LOS BANDERILLEROS</div>
        </div>
        <div class="col-md-4">
            <div class="sq_num">568 <i class="fa fa-heart-o"></i>
            </div>
        </div>
        <div class="col-md-12">
            <div class="vd-temporada">TEMPORADA 3</div>
        </div>
        <div class="col-md-12 video-desc">
            El Negro ha sido atrapado en el barrio de los pijos rivales. Su tropa, con el Kaki al frente, se decide a rescatarle en una de las misiones más arriesgadas que ha tenido que realizar a lo largo de su dilatada carrera.
            <br /><br />
            Para calmarse, como siempre, unos buenos melones y algún que otro cigarrillo con aderezo.
            <br />
            <div class='col-md-6 epi_button'>
                <a href="<?=Url::site("programas/n_programa");?>">site programa</a>
                <strong>|</strong>
                <a href="<?=Url::site("episodios/n_programa/all");?>">todos los capitulos</a>
            </div>
            <div class="col-md-6 ver-todas-web" style="margin-top: 30px;">
                Ver todas las Webseries&nbsp;&nbsp;<div class="circulo-azul">+</div>
            </div>
        </div>
        <div style="clear: both;"></div>
    </div>
    <br /><br />
    <div class='title-line'>
        <span>DESPUÉS EN TRIBO</span>
    </div>
<?php
   //Listado de proximas series
/*Extraer de BBDD la parrilla y meterlo en el controller, llamarlo e imprimirlo con el module de capitulo-mini*/
    if (count($proximos)) {
        foreach ($proximos as $proximo) {
            $controller->setData("proximo", $proximo);
            echo $controller->view("modules.capitulo-mini", "programas");
        }
    }
?>
    <div class='col-md-6'></div>
    <div class="col-md-6 ver-todas-web" style="margin-top: 30px;">
        Ver parrilla completa&nbsp;&nbsp;<div class="circulo-azul">+</div>
    </div>
</div>