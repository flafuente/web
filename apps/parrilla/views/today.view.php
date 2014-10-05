<?php defined('_EXE') or die('Restricted access'); ?>

<?php
    if (count($eventos)) {
        foreach ($eventos as $evento) {
            $controller->setData("evento", $evento);
            echo $controller->view("modules.evento");
        }
    }
?>

<script>
$( document ).ready(function () {
    $(".parrilla_big").mCustomScrollbar({
        scrollButtons:{
            enable:true
        },
        theme:"dark"
    });
});
</script>
