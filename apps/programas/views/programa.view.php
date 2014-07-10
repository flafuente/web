<?php defined('_EXE') or die('Restricted access'); ?>

<div class='col-md-12 serie_info'>
    <div class="serie_title">
        <?=Helper::sanitize($programa->titulo);?>
    </div>
    <div class="serie_when">
        <?=Helper::sanitize($programa->subtitulo);?>
    </div>
    <br />
    <div class="serie_description">
        <?=Helper::sanitize($programa->descripcion);?>
    </div>
    <div style="clear: both;"></div>
    <div class='col-md-offset-6 col-md-6 epi_button'>
        <a href="<?=Url::site("programas/n_programa");?>">site programa</a>
        <strong>|</strong>
        <a href="<?=Url::site("episodios/n_programa/all");?>">todos los capitulos</a>
    </div>
</div>

<!-- Temporadas TAB -->
<?php if (count($temporadas)) { ?>

    <ul class="nav nav-tabs" role="tablist">
        <?php foreach ($temporadas as $temporada=>$capitulos) { ?>
            <?php $active = $active ? "" : "active"; ?>
            <li class="<?=$active?>">
                <a href="#temporada<?=$temporada?>" role="tab" data-toggle="tab">
                    Temporada <?=$temporada?>
                </a>
            </li>
        <?php } ?>
    </ul>

    <?php $active = null; ?>

    <div class="tab-content">
        <?php foreach ($temporadas as $temporada=>$capitulos) { ?>
            <?php $active = $active ? "" : "active"; ?>
            <div class="tab-pane <?=$active?>" id="temporada<?=$temporada?>">
                <!-- Cápítulos -->
                <?php if (count($capitulos)) { ?>
                    <?php foreach ($capitulos as $capitulo) { ?>
                        <?php $controller->setData("capitulo", $capitulo); ?>
                        <?=$controller->view("modules.capitulo-mini"); ?>
                    <?php } ?>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
<?php } ?>
