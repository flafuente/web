<?php defined('_EXE') or die('Restricted access'); ?>

<?php
//Seleccionamos los 3 siguientes eventos
$eventos = Evento::select(array(
    'fechaInicio' => date('Y-m-d H:i:s'),
    'order' => 'fechaInicio',
    'orderDir' => 'ASC',
), 3);
?>
<?php if (count($eventos)) { ?>
    <div class='col-md-12' style='padding-left: 0px; padding-right: 0px;'>
        <div class="parrilla">
            <?php if (Registry::getUrl()->app == "tvdirecto") { ?>
            <div class="right_arrow"></div>
            <?php } ?>
            <div class="parrilla-cabecera">
                <h1>AHORA<br />EN TRIBO</h1>
                <a href="<?=Url::site('parrilla');?>?>">
                    <h2>Ver la Parrilla&nbsp;&nbsp;<div class="circulo">+</div></h2>
                </a>
            </div>
            <?php foreach ($eventos as $evento) { ?>
                <?php $capitulo = new Capitulo($evento->capituloId); ?>
                <!-- Evento -->
                <div class="parrilla-contenido <?php echo $cls; ?>">
                    <span class="hora">
                        <?=date("H:i", strtotime($evento->fechaInicio));?>
                    </span>
                    <span class="titulo">
                        <?=Helper::sanitize($capitulo->getFullTitulo());?>
                    </span>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>
