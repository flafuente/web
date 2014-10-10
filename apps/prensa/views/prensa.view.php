<?php defined('_EXE') or die('Restricted access'); ?>

<?php $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); ?>

<form class="form-horizontal" role="form" method="post" action="<?=Url::site("prensa");?>">

    <div class='col-md-12'>
        <div class="square-info-foro">
            <div class="grey" style="margin-bottom: 0px;">
                SALA DE PRENSA
                <?php if (count($notasFecha)) { ?>
                    <div class="right">
                        Filtrar por fecha
                        <select name="mes" class="change-submit" style="color: black;">
                            <?php foreach ($notasFecha as $mes => $totalNotas) { ?>
                                <option value="<?=$mes?>">
                                    <?php $tmp = explode("-", $mes); ?>
                                    <?=$meses[$tmp[1]-1];?> <?=$tmp[0];?> (<?=count($totalNotas)?>)
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                <?php } ?>
            </div>
        </div>

        <?php
        if (count($notas)) {
            foreach ($notas as $nota) {
                $controller->setData("nota", $nota);
                echo $controller->view("modules.nota-mini");
            }
            $controller->setData("pag", $pag);
            echo $controller->view("modules.pagination");
        } else { ?>
            <blockquote>
                <p> No se han encontrado notas </p>
            </blockquote>
        <?php } ?>
    </div>

</form>
