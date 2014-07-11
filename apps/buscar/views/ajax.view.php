<?php defined('_EXE') or die('Restricted access'); ?>

<?php if (count($programas) || count($capitulos)) { ?>
    <!-- Programas -->
    <?php if (count($programas)) { ?>
        <?php foreach ($programas as $programa) { ?>
            <a class="sq_result" href="<?=Url::site("programas/ver/".$programa->slug);?>">
                <div class="result">
                    <!-- <img src="<?=$programa->getThumbnailUrl();?>"> -->
                    <!--
                    <span>
                        Programa
                    </span>
                    -->
                    <h3>
                        <?=Helper::sanitize($programa->titulo); ?>
                    </h3>
                </div>
            </a>
        <?php } ?>
    <?php } ?>
    <!-- /Programas -->

    <!-- Capítulos -->
    <?php if (count($capitulos)) { ?>
        <?php foreach ($capitulos as $capitulo) { ?>
            <a class="sq_result" href="<?=Url::site("reproductor/capitulo/".$capitulo->id);?>">
                <div class="result">
                    <!-- <img src="<?=$capitulo->getThumbnailUrl();?>"> -->
                    <!--
                    <span>
                        Capítulo
                    </span>
                    -->
                    <h3>
                        <?=Helper::sanitize($capitulo->getFullTitulo()); ?>
                    </h3>
                </div>
            </a>
        <?php } ?>
    <?php } ?>
    <!-- /Capítulos -->

<?php } else { ?>
    <span class="notfound">No se han encontrado resultados.</span>
<?php } ?>

<script>
    //$(window).load(function(){
    $( document ).ready(function() {
        $("#searchResults").mCustomScrollbar({
            scrollButtons:{
                enable:true
            },
            theme:"dark"
        });
    });
</script>