<?php defined('_EXE') or die('Restricted access'); ?>

<div class='col-md-12 serie_info'>

    <!-- Player -->
    <div class="col-md-12 video">
        <?php HTML::wistiaPlayer($capitulo->cdnId); ?>

        <script src="<?=Url::template('js/vast/VASTPlugin.js')?>"></script>
        <script>
            var vastTag;

            <?php $detect = new Mobile_Detect; ?>
            <?php if ($detect->isMobile()) { ?>
                vastTag = "http://plg1.yumenetworks.com/dynamic_preroll_playlist.vast2xml?domain=1881NsMdtfSa";
            <?php } elseif ($detect->isTablet()) { ?>
                vastTag = "http://plg1.yumenetworks.com/dynamic_preroll_playlist.vast2xml?domain=1881jhDGwAAL";
            <?php } else { ?>
                vastTag = "http://cdn-01.yumenetworks.com/ym/72K6cH27X672/3560/mOjIXIJN/vpaid_tribo_sdk.xml";
            <?php } ?>

            var myAdPlugin = new VASTPlugin(
                wistiaEmbed,
                "<?=$capitulo->cdnId;?>",
                "myAdPlugin",
                escape(vastTag),
                "./"
            );
        </script>
    </div>

    <!-- Info -->
    <div class="video-info">

        <!-- Breadcrumb -->
        <div class="col-md-12 vd-ruta">
            <a href="<?=Url::site('programas/ver/'.$programa->slug);?>">
                <?=Helper::sanitize(Location::translate($programa, 'titulo'));?>
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
                <?=Helper::sanitize(Location::translate($capitulo, 'titulo'));?>
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
                <?=Language::translate('VIEW_PROGRAMAS_TEMPORADA');?> <?=$capitulo->temporada;?>
            </div>
        </div>

        <!-- Descripción -->
        <div class="col-md-12 video-desc">
            <?=Helper::sanitize(Location::translate($capitulo, 'descripcion'));?>
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
