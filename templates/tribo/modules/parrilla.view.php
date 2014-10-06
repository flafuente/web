<?php defined('_EXE') or die('Restricted access'); ?>

<?php
//Seleccionamos los 3 siguientes eventos
$eventos = Evento::select(array(
    'fechaInicio' => date('Y-m-d H:i:s', strtotime("now -30minutes")),
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
                <a href="<?=Url::site('parrilla');?>">
                    <h2>Ver la Parrilla&nbsp;&nbsp;<div class="circulo">+</div></h2>
                </a>
            </div>

            <div id="parrillaAhora">
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
                                Espacio vacío
                            <?php } ?>
                        </span>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            setInterval(function () {
                updateAhora();
            }, 60 * 1000);
        });

        function updateAhora()
        {
            $.ajax({
                type: "POST",
                url: "<?=Url::site('parrilla/ahora/');?>",
                dataType: "json"
            }).done(function (data) {
                $("#parrillaAhora").html(data["data"]["html"]);
            });
        }
    </script>
<?php } ?>
