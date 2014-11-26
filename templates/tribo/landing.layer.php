<!DOCTYPE html>
<html lang="es">

    <?=$controller->view("modules.head");?>

    <body class="body">

        <div class="mask" style="display: none;"></div>

        <!-- Top menu -->
        <?=$controller->view("modules.menus.top");?>

        <!-- Main container -->
        <div class="container main">

            <!-- Slider -->
            <?=$controller->view("modules.homeSlider");?>

            <!-- Left menu -->
            <div class='col-md-2 nopadding' style="padding-right: 5px;">
                <?=$controller->view("modules.menus.left");?>
            </div>

            <div class='col-md-10 nopadding bor_lef'>
                <div class='col-md-9 nopadding'>

                    <!-- Messages -->
                    <?=$controller->view("modules.messages");?>

                    <!-- Content -->
                    <?=$content;?>

                </div>

                <div class='col-md-3 nopadding'>
                    <!-- Twitter -->
                    <?=$controller->view("modules.twitter"); ?>
                </div>

                <div class="separador"></div>

                <div class='col-md-12 nopadding'>
                    <?=$controller->view("modules.bottomButtons");?>
                </div>

            </div>
        </div>

        <!-- Footer -->
        <?=$controller->view("modules.Footer");?>

        <!-- Debug -->
        <?=$controller->view("modules.debug.menu");?>

        <!-- Scripts -->
        <?=$controller->view("modules.generalScripts");?>

    </body>
</html>
