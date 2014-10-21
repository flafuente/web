<?php defined('_EXE') or die('Restricted access');?>

<?php $autor = new User($video->userId); ?>

<div class='col-md-12 serie_info'>
    <div class="col-md-12 video">
        <?php HTML::wistiaPlayer($video->cdnId, 558, 314); ?>
    </div>

    <!-- Info -->
    <div class="video-info" style="min-height: 435px;">

        <!-- Breadcrumb -->
        <div class="col-md-12 vd-ruta">
            Tribo News -
            <?php $categoria = new Categoria($video->categoriaId); ?>
            <a href="<?=Url::site("tribonews/categoria/".$categoria->slug);?>">
                <?=Helper::sanitize(Location::translate($categoria, 'nombre'));?>
            </a>
        </div>

        <!-- Capítulo -->
        <div class="col-md-8">
            <div class="vd-capitulo">
                <?=Helper::sanitize(Location::translate($video, 'titulo'));?>
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

                <span><?=date("d/m/Y", strtotime($video->getFecha()));?></span>
                <?=Language::translate('VIEW_TRIBONEWS_VIDEO_A_LAS');?>
                <strong><?=date("H:i", strtotime($video->dateInsert));?></strong>

            </div>
        </div>

        <!-- Likes -->
        <div class="col-md-4">
            <div class="sq_num">
                <span id="likesVideo<?=$video->id;?>">
                    <?=$video->likes;?>
                </span>
                <?php if ($video->isLiked()) { ?>
                    <?php $class = "fa-heart"; ?>
                <?php } else { ?>
                    <?php $class = "fa-heart-o"; ?>
                <?php } ?>
                <i id="likeVideo<?=$video->id;?>" class="fa <?=$class;?> like like-video" data-videoId="<?=$video->id;?>"></i>

                <!-- Plays -->
                <span>
                    <?=(int) $video->visitas;?> <?=Language::translate('VIEW_TRIBONEWS_VIDEO_REPRODUCCIONES');?>
                </span>

                <!-- Social -->
                <?php /*<br /><div class="sharesocial">
                    <?php
                    $url = $_SERVER["uri"];
                    $des = "Visto en TriboNews ".Helper::sanitize($video->titulo)." por ".Helper::sanitize($autor->getFullName())." @Tribo_tv";
                    ?>
                    <a href="http://www.facebook.com/sharer.php?u=<?= $url; ?>" target="_blank" style="min-width: 15px;" class="btn btn-facebook"><i class="fa fa-facebook"></i></a>
                    <a href="https://plus.google.com/share?url=<?= $url; ?>" target="_blank" style="min-width: 15px;" class="btn btn-google"><i class="fa fa-google-plus"></i></a>
                    <a href="http://twitter.com/home?status=<?= $des; ?>" target="_blank" style="min-width: 15px;" class="btn btn-twitter"><i class="fa fa-twitter"></i></a>
                </div>*/ ?>
            </div>
        </div>

        <!-- Descripción -->
        <div class="col-md-12 video-desc">
            <?=Helper::sanitize(Location::translate($video, 'descripcion'));?>
        </div>
        <div style="clear: both;"></div>
    </div>

    <br /><br />

    <!-- Notícias relacionadas -->
    <?php if (count($relacionados)) { ?>
        <div class='title-line'>
            <span>
                <?=Language::translate("VIEW_TRIBONEWS_RELATED_NEWS")?>
            </span>
        </div>
        <?php foreach ($relacionados as $relacionado) { ?>
            <?php $controller->setData("video", $relacionado); ?>
            <?php echo $controller->view("modules.video-mini-list"); ?>
        <?php } ?>
    <?php } ?>
    <!-- /Notícias relacionadas -->

</div>
