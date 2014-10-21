<?php defined('_EXE') or die('Restricted access'); ?>

<div class='col-md-12 serie_info'>
    <div class="serie_title">
        <?=Helper::sanitize(Location::translate($programa, 'titulo'));?>
    </div>
    <div class="serie_when">
        <?=Helper::sanitize(Location::translate($programa, 'subtitulo'));?>
    </div>
    <br />
    <div class="serie_description">
        <?=Helper::sanitize(Location::translate($programa, 'descripcion'));?>
    </div>
    <div style="clear: both;"></div>
</div>

<!-- Temporadas TAB -->
<?php if (count($temporadas)) { ?>

    <ul class="nav tabs nav-tabs" id="episodios" role="tablist">
        <?php foreach ($temporadas as $temporada=>$capitulos) { ?>
            <li>
                <a href="#temporada<?=$temporada?>" role="tab" data-toggle="tab">
                    <?=Language::translate('VIEW_PROGRAMAS_TEMPORADA');?> <?=$temporada?>
                </a>
            </li>
        <?php } ?>
    </ul>

    <?php $active = null; ?>

    <div class="tab-content">
        <?php foreach ($temporadas as $temporada=>$capitulos) { ?>
            <div class="tab-pane" id="temporada<?=$temporada?>">
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

<script>
    $(function () {
        $('#episodios a:first').tab('show');
    });
</script>
