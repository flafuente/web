<?php defined('_EXE') or die('Restricted access'); ?>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=places"></script>

<div class='col-md-12 serie_info'>

    <!-- Título -->
    <div class="square-info">
        <div class="grey">
            MIS VIDEOS <?=strtoupper($title);?> (
                <span>
                    <?=count($videos);?>
                </span>
            )
            <a class="btn-tribo-blue btn ladda-button" id="btn_subir_video" data-style="slide-right">
                <i class="fa fa-long-arrow-up"></i>
                &nbsp;&nbsp;Subir Video
            </a>
        </div>

        <!-- Subir vídeo -->
        <form method="post" name="mainForm" id="mainForm" action="<?=Url::site();?>" class="form-horizontal ajax" role="form">
            <input type="hidden" name="app" id="app" value="videos">
            <input type="hidden" name="action" id="action" value="save">
            <?php $controller->setData("categorias", $categorias); ?>
            <?php $controller->setData("tags", $tags); ?>
            <?=$controller->view("modules.subir");?>
        </form>

        <!-- Editar vídeo -->
        <div class="editgrey">
            <div class="col-md-12" id="modaledit">

            </div>
        </div>

        <!-- Vídeos -->
        <?php if (count($videos)) { ?>
            <div class="canalesd nopaddingI">
                <?php foreach ($videos as $video) { ?>
                    <?php $controller->setData("video", $video); ?>
                    <?=$controller->view("modules.video");?>
                <?php } ?>
            </div>
        <?php } ?>

       <div style="clear: both;"></div>
    </div>
</div>

<script>

    $(document).on("click",".editclick",function () {
        id = $(this).attr("data-video-id");
        $.getJSON("<?=Url::site('videos/edit');?>/" + id, function (data) {
            $("#modaledit").html(data.data.html);
        });

        return false;
    });

    <?php if (isset($_GET["uplvid"])) { ?>
        $(window).load(function () {
            $('.greysquare').add('.mask').fadeIn();
        });
    <?php } ?>

</script>
