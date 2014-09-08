<?php defined('_EXE') or die('Restricted access'); ?>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=places"></script>

<div class='col-md-12 serie_info'>

    <!-- Videos emitidos -->
    <div class="square-info">
        <div class="grey">
            MIS VIDEOS EMITIDOS (
                <span class="misvideos_n">
                    <?=count($videosEmitidos);?>
                </span>
            )
            <a class="btn-tribo-blue btn ladda-button" id="btn_subir_video" data-style="slide-right">
                <i class="fa fa-long-arrow-up"></i>
                &nbsp;&nbsp;Subir Video
            </a>
        </div>

        <form method="post" name="mainForm" id="mainForm" action="<?=Url::site();?>" class="form-horizontal ajax" role="form">
            <input type="hidden" name="app" id="app" value="">
            <input type="hidden" name="action" id="action" value="">
            <div class="greysquare">
                <div class="col-md-8">
                    <i class="fa fa-long-arrow-right btnazul btnazul-ico" style="top: 45px; color: #FFFFFF;"></i>&nbsp;&nbsp;<input id="viddis" type="file" value="Selecciona un video de tu dispositivo" class="btnazul viddis" style="top: 45px;" />
                    <!--
                    <br /><br />
                    <i class="fa fa-long-arrow-right btnazul btnazul-ico" style="top: 45px; color: #FFFFFF;"></i>&nbsp;&nbsp;<input id="vidord" type="file" value="Segunda opción si la hubiera" class="btnazul vidord" style="top: 45px;" />
                    -->
                    <br /><br />
                    <div style="text-align: right; color: #FFFFFF; width: 100%;" class="aclose">Cancelar</div>
                </div>
                <div class="col-md-4 nopaddingI" style="padding-top: 0px !important;">
                    <div class="previsualizacion" style="margin: 0px; max-width: initial !important; background-color: #9b9b9b;">
                        <span id="videoprevhelp">
                        Recuerda que tu vídeo ha de cumplir los siguientes requisitos:
                        <br /><br />
                        - El vídeo no debe pesar más de 200 MB.
                        <br />
                        - Ha de estar comprimido con el codec H.264.
                        </span>
                        <input id="buttonUpload" type="submit" value="Quiero cargar este video" class="btn-tribo-blue btn ladda-button" style="margin-top: 45px; font-size: 12px;" />
                    </div>
                </div>
            </div>

            <script>
                $(document).on("click","#buttonUpload",function () {
                    $('.secondgrey').fadeIn();
                    $("#videoprevhelp").text('Tu video de ha procesado correctamente');
                    $("#buttonUpload").fadeOut();

                    return false;
                });
                $(document).on("click",".editclick",function () {
                    /*Add content*/
                    id = $(this).attr("data-video-id");
                    $.getJSON("<?=Url::site('videos/edit');?>/" + id, function (data) {
                        $("#modaledit").html(data.data.html);
                    });

                    return false;
                });
                <?php
                if (isset($_GET["uplvid"])) {
                    ?>
                    $(window).load(function () {
                        $('.greysquare').add('.mask').fadeIn();
                    });
                    <?php
                }
                ?>
            </script>

            <!-- Subir video -->
            <div class="secondgrey">
                <div class="col-md-12 formupload">

                    <!-- Título -->
                    <div class="col-md-3 nopaddingI">
                        Nombre
                    </div>
                    <div class="col-md-9 nopaddingI">
                        <input type="text" value="" name="titulo" />
                    </div>
                    <div style="clear: both;"></div>

                    <!-- Ubicación -->
                    <div class="col-md-3 nopaddingI">
                        Ubicación
                    </div>
                    <div class="col-md-9 nopaddingI">
                        <input type="text" value="" id="ubicacion" name="localizacion" />
                    </div>
                    <div style="clear: both;"></div>

                    <!-- Categorías -->
                    <?php if (count($categorias)) { ?>
                        <div class="col-md-3 nopaddingI">Sección</div>
                        <div class="col-md-9 nopaddingI">
                            <?=HTML::select("categoriaId", $categorias, null, null, null, array("display" => "nombre")); ?>
                        </div>
                        <div style="clear: both;"></div>
                    <?php } ?>

                    <!-- Descripción -->
                    <div class="col-md-3 nopaddingI">
                        Descripción
                    </div>
                    <div class="col-md-9 nopaddingI">
                        <textarea type="text" name="descripcion"></textarea>
                    </div>
                    <div style="clear: both;"></div>

                    <!-- Texto -->
                    <div class="col-md-3 nopaddingI">
                        Texto
                    </div>
                    <div class="col-md-9 nopaddingI">
                        <input type="text" value="" name="texto" />
                    </div>
                    <div style="clear: both;"></div>

                    <!-- Tags -->
                    <?php if (count($tags)) { ?>
                        <div class="col-md-3 nopaddingI">
                            Tags
                        </div>
                        <div class="col-md-9 nopaddingI">
                            <?=HTML::select("tags[]", $tags, null, array("class" => "select2", "multiple" => "true"), null, array("display" => "nombre")); ?>
                        </div>
                        <div style="clear: both;"></div>
                    <?php } ?>

                    <div class="col-md-3 nopaddingI">Adjuntos</div>
                    <div class="col-md-9 nopaddingI"><input type="text" value="" name="adjuntos" /></div>
                    <div style="clear: both;"></div>
                    <button type="submit" class="btn-tribo-blue btn ladda-button" style="float: right;"><i class="fa fa-check"></i>&nbsp;&nbsp;Publicar Video</button>
                </div>
            </div>
        </form>
        <div class="editgrey">
            <div class="col-md-12" id="modaledit">

            </div>
        </div>
        <?php if (count($videosEmitidos)) { ?>
            <div class="canalesd nopaddingI">
                <?php foreach ($videosEmitidos as $video) { ?>
                    <?php $controller->setData("video", $video); ?>
                    <?=$controller->view("modules.video");?>
                <?php } ?>
            </div>
        <?php } ?>
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
                    <?php $controller->setData("video", $video); ?>
                    <?=$controller->view("modules.video");?>
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
                    <?php $controller->setData("video", $video); ?>
                    <?=$controller->view("modules.video");?>
                <?php } ?>
            </div>
        <?php } ?>
       <div style="clear: both;"></div>
    </div>
</div>

<!-- Google Autocomplete -->
<script>
    $("#ubicacion").placepicker();
</script>
