<?php defined('_EXE') or die('Restricted access'); ?>

<div class='col-md-12 serie_info'>

    <!-- Player -->
    <div class="col-md-12 video">
        <?php HTML::wistiaPlayer($capitulo->cdnId); ?>
    </div>

    <!-- Info -->
    <div class="video-info">

        <!-- Breadcrumb -->
        <div class="col-md-12 vd-ruta">
            <a href="<?=Url::site('programas/ver/'.$programa->slug);?>">
                <?=Helper::sanitize($programa->titulo);?>
            </a>
             /
            Capítulos
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
                <span>
                    <?=$capitulo->likes;?>
                </span>
                <?php if ($capitulo->isLiked()) { ?>
                    <i class="fa fa-heart like"></i>
                <?php } else { ?>
                    <i class="fa fa-heart-o like"></i>
                <?php } ?>
            </div>
        </div>

        <!-- Info -->
        <div class="col-md-12">
            <div class="vd-attr">
                <?=Helper::sanitize($capitulo->duracion);?> |
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
            site programa
            <strong>|</strong>
            todos los capitulos
        </a>
    </div>

    <!-- Link sección -->
    <?php $seccion = new Seccion($programa->seccionId); ?>
    <?php if ($seccion->id) { ?>
        <div class="col-md-6 ver-todas-web" style="margin-top: 30px;">
            <a href="<?=Url::site("programas/seccion/".$seccion->slug);?>">
                Ver todas las Webseries&nbsp;&nbsp;<div class="circulo-azul">+</div>
            </a>
        </div>
    <?php } ?>

</div>

<!-- Like/Unlike -->
<script>

    var likes = parseInt($(".sq_num span").html());

    $(document).on('click', '.like', function (e) {
        if ($(this).hasClass("fa-heart-o")) {
            like(<?=$capitulo->id;?>);
        } else {
            unlike(<?=$capitulo->id;?>);
        }
    });

    function like(capituloId)
    {
        $.ajax("<?=Url::site("reproductor/like");?>/" + capituloId).done(function () {
            $(".like").removeClass("fa-heart-o");
            $(".like").addClass("fa-heart");
            likes++;
            updateLikesCounter();
        });
    }

    function unlike(capituloId)
    {
        $.ajax("<?=Url::site("reproductor/unlike");?>/" + capituloId).done(function () {
            $(".like").addClass("fa-heart-o");
            $(".like").removeClass("fa-heart");
            likes--;
            updateLikesCounter();
        });
    }

    function updateLikesCounter()
    {
        $(".sq_num span").html(likes)
    }

</script>
