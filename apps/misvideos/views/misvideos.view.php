<?php defined('_EXE') or die('Restricted access');

?>
<div class='col-md-12 serie_info'>
    <div class="square-info">
        <div class="grey">
            MIS VIDEOS EMITIDOS (<span class="misvideos_n">12</span>)
            <a class="btn-tribo-blue btn ladda-button" data-style="slide-right" href="<?=Url::site("videos/nuevo");?>">
                <i class="fa fa-long-arrow-up"></i>
                &nbsp;&nbsp;Subir Video
            </a>
        </div>
        <div class="canalesd nopaddingI">
            <?php for($x=0; $x<5; $x++){ showVideos("malviviendo.jpg", "Malviviendo", "T0".($x+1), date("Y-m-d H:i:s"), "enlace".$x); } ?>
        </div>
        <div class="simple-pagination">
        <!-- class sel para el selected -->
        << < <span class="sp-sel">1</span>   2   3 > >>
        </div>
       <div style="clear: both;"></div>
    </div>
    <br /><br />
    <div class="square-info">
        <div class="grey">
            MIS VIDEOS PENDIENTES (<span class="misvideos_no">3</span>)
        </div>
        <div class="canalesd nopaddingI">
            <?php for($x=0; $x<3; $x++){ showVideos("malviviendo.jpg", "Malviviendo", "T0".($x+1), date("Y-m-d H:i:s"), "enlace".$x); } ?>
        </div>
       <div style="clear: both;"></div>
    </div>
    <br /><br />
    <div class="square-info">
        <div class="grey">
            MIS VIDEOS RECHAZADOS (<span class="misvideos_nr">1</span>)
        </div>
        <div class="canalesd nopaddingI">
            <?php for($x=0; $x<1; $x++){ showVideos("malviviendo.jpg", "Malviviendo", "T0".($x+1), date("Y-m-d H:i:s"), "enlace".$x); } ?>
        </div>
       <div style="clear: both;"></div>
    </div>
</div>


<?php
function showVideos($imagen, $titulo, $subtitulo, $fecha, $enlace){
    ?>
    <div class="mi-video">
        <div class="col-md-6 mi-video-prev"><img src="<?=Url::template("img/programas/".$imagen);?>" /></div>
        <div class="col-md-6" style="padding-top: 20px;">
            <span class="mivid-titulo"><?=$titulo;?></span>
            <br />
            <span class="mivid-subtitulo"><?=$subtitulo;?></span>
            <br />
            <span class="mv-fecha"><?=date("d/m/Y", strtotime($fecha));?> a las <?=date("H:i", strtotime($fecha));?></span>
            <span class="btn btn-tribo-grey" urledit="<?=$enlace;?>" style="float: right;">Editar</span>
        </div>
    </div>
    <div style="clear: both;"></div>
    <?php
}
?>