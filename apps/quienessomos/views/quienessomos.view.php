<?php defined('_EXE') or die('Restricted access'); ?>

<div class='col-md-12 serie_info'>

    <div class="col-md-12 video">
        <?=HTML::wistiaPlayer("2uu6gseu6n", null, 320);?>
    </div>

    <div class="video-info">

        <?php $articulo = new Articulo(3); ?>
        <?php echo $articulo->texto; ?>

        <div style="clear: both;"></div>

    </div>

</div>
