<?php defined('_EXE') or die('Restricted access'); ?>

<div class='col-md-12'>
    <div class="square-info-foro">
        <div class="grey" style="margin-bottom: 0px;">
            SALA DE PRENSA
            <div class="right">
                Ordenar por fecha
                <select style="color: black;">
                    <option>Ascendente</option>
                    <option>Descendente</option>
                </select>
            </div>
        </div>
    </div>

    <?php
    if (count($notas)) {
        foreach ($notas as $nota) {
            $controller->setData("nota", $nota);
            echo $controller->view("modules.nota-mini");
        }
    } else { ?>
        <blockquote>
            <p> No se han encontrado notas </p>
        </blockquote>
    <?php } ?>
</div>
