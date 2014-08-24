<?php defined('_EXE') or die('Restricted access'); ?>

<div class='col-md-12 serie_info'>

    <!-- Videos emitidos -->
    <div class="square-info">
        <div class="grey">
            MIS VIDEOS EMITIDOS (
            	<span class="misvideos_n">
            		<?=count($videosEmitidos);?>
            	</span>
            )
            <a class="btn-tribo-blue btn ladda-button" data-style="slide-right" href="<?=Url::site("videos/nuevo");?>">
                <i class="fa fa-long-arrow-up"></i>
                &nbsp;&nbsp;Subir Video
            </a>
        </div>
        <?php if (count($videosEmitidos)) { ?>
	        <div class="canalesd nopaddingI">
	            <?php foreach ($videosEmitidos as $video) { ?>
			        <div class="col-md-3 th_video">
			            <?php $controller->setData("video", $video); ?>
			            <?=$controller->view("modules.video");?>
			        </div>
			    <?php } ?>
	        </div>
	    <?php } ?>
        <div class="simple-pagination">
        <!-- class sel para el selected -->
        << < <span class="sp-sel">1</span>   2   3 > >>
        </div>
       <div style="clear: both;"></div>
    </div>
    <br /><br />

    <!-- Videos pendientes -->
    <div class="square-info">
        <div class="grey">
            MIS VIDEOS PENDIENTES (
            	<span class="misvideos_no">
            		<?=count($videosPendientes)?>
            	</span>
            )
        </div>
        <?php if (count($videosPendientes)) { ?>
	        <div class="canalesd nopaddingI">
	            <?php foreach ($videosPendientes as $video) { ?>
			        <div class="col-md-3 th_video">
			            <?php $controller->setData("video", $video); ?>
			            <?=$controller->view("modules.video");?>
			        </div>
			    <?php } ?>
	        </div>
	    <?php } ?>
       <div style="clear: both;"></div>
    </div>
    <br /><br />

    <!-- Videos rechazados -->
    <div class="square-info">
        <div class="grey">
            MIS VIDEOS RECHAZADOS (
            	<span class="misvideos_nr">
            		<?=count($videosRechazados);?>
            	</span>
            )
        </div>
        <?php if (count($videosRechazados)) { ?>
	        <div class="canalesd nopaddingI">
	            <?php foreach ($videosRechazados as $video) { ?>
			        <div class="col-md-3 th_video">
			            <?php $controller->setData("video", $video); ?>
			            <?=$controller->view("modules.video");?>
			        </div>
			    <?php } ?>
	        </div>
	    <?php } ?>
       <div style="clear: both;"></div>
    </div>
</div>
