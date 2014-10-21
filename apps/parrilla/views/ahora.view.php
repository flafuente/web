<?php defined('_EXE') or die('Restricted access'); ?>

<?php if (count($eventos)) { ?>
    <?php foreach ($eventos as $evento) { ?>
        <?php
        $capitulo = new Capitulo($evento->capituloId);
        if ($capitulo->id) {
            $programa = new Programa($capitulo->programaId);
        }
        ?>
        <!-- Evento -->
        <div class="parrilla-contenido <?php echo $cls; ?>">
            <span class="hora">
                <?=date("H:i", strtotime($evento->fechaInicio));?>
            </span>
            <span class="titulo">
                <?php if ($capitulo->id) { ?>
                    <a href="<?=Url::site("programas/ver/".$programa->slug);?>">
                        <?=Helper::sanitize($capitulo->getProgramaTitulo($programa)); ?>
                    </a>
                <?php } else { ?>
                    <?=Translate::Language("VIEW_PARRILLA_AHORA_EMPTY_SPACE"); ?>
                <?php } ?>
            </span>
        </div>
    <?php } ?>
<?php } ?>
