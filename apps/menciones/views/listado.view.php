<?php defined('_EXE') or die('Restricted access'); ?>

<div class='col-md-12'>
    <div class="square-info-foro">
        <div class="grey" style="margin-bottom: 0px;">
            HABLAN DE NOSOTROS
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
            <p> No se han encontrado menciones </p>
        </blockquote>
    <?php } ?>
</div>
