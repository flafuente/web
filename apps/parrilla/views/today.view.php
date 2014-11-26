<?php defined('_EXE') or die('Restricted access'); ?>

<?php
    if (count($eventos)) {
        foreach ($eventos as $evento) {
            $controller->setData("evento", $evento);
            echo $controller->view("modules.evento");
        }
    }
?>
