<?php defined('_EXE') or die('Restricted access');?>

<?php $autor = new User($video->userId); ?>

<div class='col-md-12 serie_info'>
    <div class="col-md-12 video">
        <?php HTML::wistiaPlayer($video->cdnId, 558, 314); ?>
    </div>

    <!-- Info -->
    <div class="video-info">

        <!-- Breadcrumb -->
        <div class="col-md-12 vd-ruta">
            Tribo News -
            <?php $categoria = new Categoria($video->categoriaId); ?>
            <!--<a href="<?=Url::site($categoria->urlCategoria);?>">-->
                <?=Helper::sanitize($categoria->nombre);?>
            <!--</a>-->
        </div>

        <!-- Capítulo -->
        <div class="col-md-8">
            <div class="vd-capitulo">
                <?=Helper::sanitize($video->titulo);?>
            </div>
            <div style="clear: both;"></div>
            <div class="vd-capituloInfo">

                <?php $comunidad = new Comunidad($video->comunidadId); ?>
                <?php if ($comunidad->id) { ?>
                    En <span><?=Helper::sanitize($comunidad->nombre);?></span>
                <?php } ?>

                <?php if ($autor->id) { ?>
                    por <strong><?=Helper::sanitize($autor->getFullName());?></strong> |
                <?php } ?>

                <span><?=date("d/m/Y", strtotime($video->dateInsert));?></span> a las <strong><?=date("H:i", strtotime($video->dateInsert));?></strong>

            </div>
        </div>

        <!-- Likes -->
        <div class="col-md-4">
            <div class="sq_num">
                <span>
                    <?=(int) $video->likes;?>
                </span>
                <?php if ($video->isLiked()) { ?>
                    <i class="fa fa-heart like"></i>
                <?php } else { ?>
                    <i class="fa fa-heart-o like"></i>
                <?php } ?>
                <div style="clear: both;"></div>
                <span>
                    <?=(int) $video->visitas;?> reproducciones
                </span>
            </div>
        </div>
        <!-- Descripción -->
        <div class="col-md-12 video-desc">
            <?=Helper::sanitize($video->descripcion);?>
        </div>
        <div style="clear: both;"></div>
    </div>

    <br /><br />

    <!-- Notícias relacionadas -->
    <?php if (count($relaccionadas)) { ?>
        <div class='title-line'>
            <span>NOTICIAS RELACIONADAS</span>
        </div>
        <?php foreach ($relaccionadas as $relaccionada) { ?>
            <?php $controller->setData("proximo", $proximo); ?>
            <?php echo $controller->view("modules.video-mini", "programas"); ?>
        <?php } ?>
    <?php } ?>
    <!-- /Notícias relacionadas -->

</div>

<!-- Like/Unlike -->
<script>

    var likes = parseInt($(".sq_num span:first-child").html());

    $(document).on('click', '.like', function (e) {
        if ($(this).hasClass("fa-heart-o")) {
            like(<?=$video->id;?>);
        } else {
            unlike(<?=$video->id;?>);
        }
    });

    function like(videoId)
    {
        $.ajax("<?=Url::site("tribonews/like");?>/" + videoId).done(function () {
            $(".like").removeClass("fa-heart-o");
            $(".like").addClass("fa-heart");
            likes++;
            updateLikesCounter();
        });
    }

    function unlike(videoId)
    {
        $.ajax("<?=Url::site("tribonews/unlike");?>/" + videoId).done(function () {
            $(".like").addClass("fa-heart-o");
            $(".like").removeClass("fa-heart");
            likes--;
            updateLikesCounter();
        });
    }

    function updateLikesCounter()
    {
        $(".sq_num span:first-child").html(likes)
    }

</script>
