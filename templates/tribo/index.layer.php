<!DOCTYPE html>
<html lang="es">

    <?=$controller->view("modules.head");?>

    <body class="body">

        <div class="mask" style="display: none;"></div>

        <!-- Top menu -->
        <?=$controller->view("modules.menus.top");?>

        <!-- Main container -->
        <div class="container main">

            <!-- Left menu -->
            <div class='col-md-2 nopadding' style="padding-right: 5px;">
                <?=$controller->view("modules.menus.left");?>
            </div>

            <div class='col-md-10 nopadding bor_lef'>
                <?php $url = Registry::getUrl(); ?>
                <?php $md = ($url->app != "foro") ? 9 : 12; ?>

                <div class='col-md-<?=$md;?> nopadding divprincipal'>

                    <!-- Messages -->
                    <?=$controller->view("modules.messages");?>

                    <!-- Content -->
                    <?=$content;?>

                </div>

                <?php if ($url->app != "foro") { ?>
                    <div class='col-md-3 nopadding'>

                        <!-- Twitter -->
                        <?=$controller->view("modules.twitter"); ?>

                    </div>
                <?php } ?>

                <?php if ($url->app == "haztetriber") { ?>
                    <div class='col-md-12 nopadding'>
                        <?=$controller->view("views.registroBottom"); ?>
                    </div>
                <?php } ?>

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
