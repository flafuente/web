<?php defined('_EXE') or die('Restricted access'); ?>

<!-- Browse video -->
<div class="greysquare">
    <div class="col-md-8">
        <i class="fa fa-long-arrow-right btnazul btnazul-ico" style="top: 45px; color: #FFFFFF;"></i>
        &nbsp;&nbsp;
        <input type="hidden" name="file" id="filename" value="">
        <input id="fileupload" name="files[]" accept="video/*" type="file" value="Selecciona un video de tu dispositivo" class="btnazul viddis" style="top: 45px;" />
        <br /><br />
        <!-- The global progress bar -->
        <div id="progress" class="progress" style="display:none">
            <div class="progress-bar progress-bar-success"></div>
        </div>
        <!-- The container for the uploaded files -->
        <div id="files" class="files"></div>
        <div style="text-align: right; color: #FFFFFF; width: 100%;" class="aclose">
            Cancelar
        </div>
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
                <?=HTML::select("categoriaId", $categorias, null, array("id" => "categoriaId"), null, array("display" => "nombre")); ?>
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

        <!-- Adjuntos -->
        <div class="col-md-3 nopaddingI">
            Adjuntos
        </div>
        <div class="col-md-9 nopaddingI">
            <input type="text" value="" name="adjuntos" />
        </div>

        <div style="clear: both;"></div>
        <button type="submit" class="btn-tribo-blue btn ladda-button" style="float: right;">
            <i class="fa fa-check"></i>
            &nbsp;&nbsp;
            Publicar Video
        </button>
    </div>
</div>

<script>
    /* Gooogle Maps Autocomplete */
    $("#ubicacion").placepicker();

    /* Video Upload */
    $(function () {
        //File Upload
        $('#fileupload').fileupload({
            maxChunkSize: 10000000,
            url: "<?=Url::site('videos/upload');?>",
            formData: "",
            dataType: 'json',
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    if (!file.error) {
                        $('<p/>').text(file.name).appendTo('#files');
                        $("#filename").val(file.name);
                        $('.secondgrey').fadeIn();
                        $("#videoprevhelp").text('Tu video de ha procesado correctamente');
                        $("#buttonUpload").fadeOut();
                    } else {
                        $("#filename").val("");
                        alert(file.error);
                    }
                });
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        })
    });

    /* Upload video hotlink */
    <?php if (isset($_GET["uplvid"])) { ?>
        $(window).load(function () {
            $('.greysquare').add('.mask').fadeIn();
        });
    <?php } ?>

</script>
