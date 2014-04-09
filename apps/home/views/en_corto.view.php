<?php defined('_EXE') or die('Restricted access'); ?>
<!-- Logo Cabecera -->
<div class="contenido en_corto">
    <div class="tu_haces_in">
        <img class="logo" src="<?=Url::template("/img/tu_haces/en_corto/logo.png");?>" alt="Tribo en Corto" title="Tribo en Corto" />
        <br />
        <br />
        <img class="banner" src="<?=Url::template("/img/tu_haces/en_corto/banner.png");?>" alt="Tribo en Corto" title="Tribo en Corto" />
    </div>
    <div style="clear: both;"></div><br />
    <div class="col-md-9 main_tu_haces">
        <h3>Un espacio creativo para los amantes del cine</h3>
        Nuestra apuesta por la creatividad alternativa.<br />
        Da a conocer tus dotes como director, actor o productor. Sube tu cortometraje, y da a conocer tu visión personal del mundo.<br />
        <h3>Queremos ser tu altavoz</h3>
        Una oportunidad para expresar tu creatividad y conocer que está pasando en el mundo del cine alternativo.
        <br /><br /><br />
        <a href="" class="botonsubir"><i class="fa fa-arrow-up" style="margin-right: 10px;"></i>Sube tu corto</a>
        <br /><br />
        <a href="">¿Cómo subir un corto?</a>
        <br /><br /><br />
        <h4 style="width: 183px;">Cortos más populares</h4>
        <?php
        for($x=0; $x<4; $x++){
            ?>
            <div class="col-md-3 th_video">
                <img src="<?=Url::template("/img/tu_haces/en_corto/video.png");?>" alt="Título del Video" title="Título del Video" />
                <br />
                <div class="th_video_info">
                    <div style="float: left;">
                        <img style="width: 34px;" src="<?=Url::template("/img/tu_haces/en_corto/user_icon.png");?>" alt="UserName" title="Username" />
                    </div>
                    <div>
                        <span class="th_titulo">Título 00<?php echo $x; ?></span>
                        <br />
                        <span class="th_hace">De <strong>Autor</strong> hace <?php echo rand(1, 3); ?> días</span>
                    </div>
                </div>
                
            </div>
            <?php
        }
        ?>
        <div style="clear: both;"></div><br />

        <h4 style="width: 124px;">Últimos Cortos</h4>
        <?php
        for($x=0; $x<4; $x++){
            ?>
            <div class="col-md-3 th_video">
                <img src="<?=Url::template("/img/tu_haces/en_corto/video.png");?>" alt="Título del Video" title="Título del Video" />
                <br />
                <div class="th_video_info">
                    <div style="float: left;">
                        <img style="width: 34px;" src="<?=Url::template("/img/tu_haces/en_corto/user_icon.png");?>" alt="UserName" title="Username" />
                    </div>
                    <div>
                        <span class="th_titulo">Título 00<?php echo $x; ?></span>
                        <br />
                        <span class="th_hace">De <strong>Autor</strong> hace <?php echo rand(1, 3); ?> días</span>
                    </div>
                </div>
                
            </div>
            <?php
        }
        ?>
    </div>
    <div class="col-md-3 lat_tu_haces">
        <a class="twitter-timeline" href="https://twitter.com/pepocivs" data-widget-id="453902978185822208">Tweets por @pepocivs</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        <br /><br />
        <img class="banner" src="<?=Url::template("/img/tu_haces/en_corto/siguenos.png");?>" alt="Siguenos en las Redes sociales" title="Siguenos en las Redes sociales" />
        <?=$controller->view("modules.social");?>
        <img class="comenta" src="<?=Url::template("/img/tu_haces/en_corto/comenta_tribo.png");?>" alt="Comenta Tribo" title="Comenta Tribo" />
    </div>
    <div style="clear: both;"></div><br />
    <div class="col-md-1"></div>
    <div class="col-md-2 sec_down thin_green selected"></div>
    <div class="col-md-2 sec_down thin_yellow"></div>
    <div class="col-md-2 sec_down thin_red"></div>
    <div class="col-md-2 sec_down thin_pink"></div>
    <div class="col-md-2 sec_down thin_purple"></div>
    

</div>
<!-- tribo Cortos, noticias... -->




<div style="clear: both;"></div><br />