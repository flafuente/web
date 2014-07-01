<?php defined('_EXE') or die('Restricted access'); ?>
<!-- Sub cabecera -->
<div class="tu_haces">
    <img class="img_tuhaces" src="<?=Url::template("/img/tu_haces/tu_haces.png");?>" alt="Tu haces tribo" title="Tú haces Tribo" />
</div>

<!-- tribo Cortos, noticias... -->

<a href="<?php echo Url::site("videos"); ?>">
    <div class="col-md-2 c_green th_square">
        <!--
        <h1><span>tribo</span> en Corto</h1>
        -->
        <div class="descr">Un espacio creativo para<br />los amantes del cine</div>
    </div>
</a>

<a href="<?php echo Url::site("home/noticias"); ?>">
    <div class="col-md-2 c_yellow th_square">
    	<!--
        <h1><span>tribo</span> Notícias</h1>
        -->
        <div class="descr">Ven a tribo y forma parte<br />de la cadena</div>
    </div>
</a>
<a href="<?php echo Url::site("home/musica"); ?>">
    <div class="col-md-2 c_red th_square">
    	<!--
        <h1><span>tribo</span> Música</h1>
        -->
        <div class="descr">Vuelve a ser fan</div>
    </div>
</a>

<a href="<?php echo Url::site("home/juegos"); ?>">
    <div class="col-md-2 c_pink th_square">
    	<!--
        <h1><span>tribo</span> Juegos</h1>
        -->
        <div class="prox">-PROXIMAMENTE-</div>
    </div>
</a>

<a href="<?php echo Url::site("home/fotos"); ?>">
    <div class="col-md-2 c_purple th_square">
        <!--
        <h1><span>tribo</span></h1>
        <p>Tus Fotos</p>
        <p>Tus Videos</p>
        -->
        <div class="descr">Exprésate y da a<br />conocer tu personalidad</div>
    </div>
</a>

<div style="clear: both;"></div>

<!-- LOGIN -->
<div class="col-md-10 th_entra">
	<img src="<?=Url::template("/img/tu_haces/tuhacestribo.png");?>" alt="Tu haces tribo" title="Tú haces Tribo" />
	<div style="clear: both;"></div>
	<br />
	<?=$controller->view("modules.login", "login");?>
	<div style="clear: both;"></div>
	<div class="th_botm">
		<span style="color: #FFFFFF;">¿Necesitas una cuenta?</span>
		<a href="<?php echo Url::site("login/register"); ?>" style="font-weight: bold;">Registrate</a>
	</div>
</div>
<div style="clear: both;"></div>
<br />