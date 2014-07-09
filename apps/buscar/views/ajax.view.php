<?php defined('_EXE') or die('Restricted access'); ?>

<?php if (count($programas) || count($capitulos)) { ?>

    <!-- Programas -->
    <?php if (count($programas)) { ?>
        <?php foreach ($programas as $programa) { ?>
            <a href="<?=Url::site("programas/ver/".$programa->slug);?>">
                <div class="result">
                    <img src="<?=$programa->getThumbnailUrl();?>">
                    <h3>
                        <?=Helper::sanitize($programa->titulo); ?>
                    </h3>
                    <span>
                        Programa
                    </span>
                </div>
            </a>
        <?php } ?>
    <?php } ?>
    <!-- /Programas -->

    <!-- Capítulos -->
    <?php if (count($capitulos)) { ?>
        <?php foreach ($capitulos as $capitulo) { ?>
            <a href="<?=Url::site("reproductor/capitulo/".$capitulo->id);?>">
                <div class="result">
                    <img src="<?=$capitulo->getThumbnailUrl();?>">
                    <h3>
                        <?=Helper::sanitize($capitulo->getFullTitulo()); ?>
                    </h3>
                    <span>
                        Capítulo
                    </span>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
    <!-- /Capítulos -->

<?php } else { ?>
    No se han encontrado resultados.
<?php } ?>
