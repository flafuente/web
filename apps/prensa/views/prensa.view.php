<?php defined('_EXE') or die('Restricted access'); ?>

<?php $meses = Array("1" => Language::translate("MESES_ENERO"),
                  "2" => Language::translate("MESES_FEBRERO"),
                  "3" => Language::translate("MESES_MARZO"),
                  "4" => Language::translate("MESES_ABRIL"),
                  "5" => Language::translate("MESES_MAYO"),
                  "6" => Language::translate("MESES_JUNIO"),
                  "7" => Language::translate("MESES_JULIO"),
                  "8" => Language::translate("MESES_AGOSTO"),
                  "9" => Language::translate("MESES_SEPTIEMBRE"),
                  "10" => Language::translate("MESES_OCTUBRE"),
                  "11" => Language::translate("MESES_NOVIEMBRE"),
                  "12" => Language::translate("MESES_DICIEMBRE")); ?>

<form class="form-horizontal" role="form" method="post" action="<?=Url::site("prensa");?>">

    <div class='col-md-12'>
        <div class="square-info-foro">
            <div class="grey" style="margin-bottom: 0px;">
                <?=Language::translate("VIEW_PRENSA_LISTAR_TITLE");?>
                <?php if (count($notasFecha)) { ?>
                    <div class="right">
                        <?=Language::translate("VIEW_PRENSA_FILTRO_FECHA");?>
                        <?php $s[$_REQUEST['mes']] = 'selected'; ?>
                        <select name="mes" class="change-submit" style="color: black;">
                            <?php foreach ($notasFecha as $mes => $totalNotas) { ?>
                                <option value="<?=$mes?>" <?=$s[$mes]?>>
                                    <?php $tmp = explode("-", $mes); ?>
                                    <?=$meses[$tmp[1]-1];?> <?=$tmp[0];?> (<?=(int) $totalNotas?>)
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
                <p><?=Language::translate("VIEW_PRENSA_LISTAR_TITLE");?></p>
            </blockquote>
        <?php } ?>
    </div>

</form>
