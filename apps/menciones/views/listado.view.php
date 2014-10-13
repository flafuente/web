<?php defined('_EXE') or die('Restricted access'); ?>

<div class='col-md-12'>
    <div class="square-info-foro">
        <div class="grey" style="margin-bottom: 0px;">
            <?=Language::translate("VIEW_MENCIONES_LISTADO_TITLE");?>
        </div>
    </div>

    <?php
    if (count($menciones)) {
        foreach ($menciones as $mencion) {
            $controller->setData("mencion", $mencion);
            echo $controller->view("modules.mencion-mini");
        }
        $controller->setData("pag", $pag);
        echo $controller->view("modules.pagination");
    } else { ?>
        <blockquote>
            <p> <?=Language::translate("VIEW_MENCIONES_LISTADO_EMPTY");?> </p>
        </blockquote>
    <?php } ?>
</div>
