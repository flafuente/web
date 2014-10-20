<?php defined('_EXE') or die('Restricted access'); ?>

<div class='col-md-12 serie_info'>

    <!-- Player -->
    <div class="col-md-12 video">
        <?php HTML::wistiaPlayer($capitulo->cdnId); ?>

        <?php if ($_REQUEST['vast']) { ?>
            <script src="<?=Url::template('js/vast/VASTPlugin.js')?>"></script>
            <script>
            //Ad implementation
            var vastTag;
            if (!isMobile.any()) {
                vastTag = "http://shadowcdn-01.yumenetworks.com/ym/1B3uA91O2152/1349/HifvrHol/vpaid_as3.xml";
            } else {
                vastTag = "http://ad3.liverail.com/?LR_PUBLISHER_ID=1331&LR_CAMPAIGN_ID=229&LR_SCHEMA=vast2";
            }
            var myAdPlugin = new VASTPlugin(
                wistiaEmbed, //wistiaEmbed Api
                "<?=$capitulo->cdnId;?>", // wistia ID
                "myAdPlugin", // Ad plugin Api
                escape(vastTag), // ad vast/vpaid tag
                "./"
            ); // library path
            </script>
        <?php } ?>
    </div>

    <!-- Info -->
    <div class="video-info">

        <!-- Breadcrumb -->
        <div class="col-md-12 vd-ruta">
            <a href="<?=Url::site('programas/ver/'.$programa->slug);?>">
                <?=Helper::sanitize($programa->titulo);?>
            </a>
             /
            <?=Language::translate("VIEW_REPRODUCTOR_CAPITULOS")?>
        </div>

        <!-- Capítulo -->
        <div class="col-md-8">
            <div class="vd-codigo">
                <?=$capitulo->getNumero();?> |
            </div>
            <div class="vd-capitulo">
                <?=Helper::sanitize($capitulo->titulo);?>
            </div>
        </div>

        <!-- Likes -->
        <div class="col-md-4">
            <div class="sq_num">
                <span id="likesCapitulo<?=$capitulo->id;?>">
                    <?=$capitulo->likes;?>
                </span>
                <?php if ($capitulo->isLiked()) { ?>
                    <?php $class = "fa-heart"; ?>
                <?php } else { ?>
                    <?php $class = "fa-heart-o"; ?>
                <?php } ?>
                <i id="likeCapitulo<?=$capitulo->id;?>" class="fa <?=$class;?> like like-capitulo" data-capituloId="<?=$capitulo->id;?>"></i>
            </div>
            <div class="clear: both;"></div>
            <?php /*<br />
            <div class="sharesocial">
                <?php
                $url = $_SERVER["uri"];
                $des = "Visto en triboTV ".Helper::sanitize($programa->titulo)." - ".Helper::sanitize($capitulo->titulo)." @Tribo_tv";
                ?>
                <a href="http://www.facebook.com/sharer.php?u=<?= $url; ?>" target="_blank" style="min-width: 15px;" class="btn btn-facebook"><i class="fa fa-facebook"></i></a>
                <a href="https://plus.google.com/share?url=<?= $url; ?>" target="_blank" style="min-width: 15px;" class="btn btn-google"><i class="fa fa-google-plus"></i></a>
                <a href="http://twitter.com/home?status=<?= $des; ?>" target="_blank" style="min-width: 15px;" class="btn btn-twitter"><i class="fa fa-twitter"></i></a>
            </div>*/?>
        </div>

        <!-- Info -->
        <div class="col-md-12">
            <div class="vd-attr">
                <!-- Duración -->
                <?php if ($capitulo->duracion && $capitulo->duracion != "00:00:00") { ?>
                    <?=Helper::sanitize($capitulo->duracion);?> |
                <?php  } ?>
                <!-- Fecha emisión -->
                <?php if ($capitulo->fechaEmision && $capitulo->fechaEmision != "0000-00-00") { ?>
                    <?=Helper::sanitize($capitulo->fechaEmision);?> |
                <?php  } ?>
            </div>
            <div class="vd-temporada">
                TEMPORADA <?=$capitulo->temporada;?>
            </div>
        </div>

        <!-- Descripción -->
        <div class="col-md-12 video-desc">
            <?=Helper::sanitize($capitulo->descripcion);?>
        </div>

        <div style="clear: both;"></div>
    </div>

    <!-- Capítulos -->
    <?php
    //Anterior
    $controller->setData("capitulo", $capitulo->getPrevious());
    echo $controller->view("modules.capitulo-mini", "programas");
    ?>

    <?php
    //Siguiente
    $controller->setData("capitulo", $capitulo->getNext());
    echo $controller->view("modules.capitulo-mini", "programas");
    ?>

    <!-- Links-->
    <div class='col-md-6 epi_button'>
        <a href="<?=Url::site("programas/ver/".$programa->slug);?>">
            <?=Language::translate("VIEW_REPRODUCTOR_SITE")?>
            <strong>|</strong>
            <?=Language::translate("VIEW_REPRODUCTOR_ALLEPISODES")?>
        </a>
    </div>

    <!-- Link sección -->
    <?php $seccion = new Seccion($programa->seccionId); ?>
    <?php if ($seccion->id) { ?>
        <div class="col-md-6 ver-todas-web" style="margin-top: 30px;">
            <a href="<?=Url::site("programas/seccion/".$seccion->slug);?>">
                <?=Language::translate("VIEW_REPRODUCTOR_VER")?> <?=$seccion->nombre;?>&nbsp;&nbsp;<div class="circulo-azul">+</div>
            </a>
        </div>
    <?php } ?>

</div>
