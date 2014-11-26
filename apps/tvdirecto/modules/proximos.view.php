<?php defined('_EXE') or die('Restricted access'); ?>

<?php if (count($eventos)) { ?>
    <br /><br />
    <div class='title-line'>
        <span>
            <?=Language::translate("VIEW_TVDIRECTO_PROXIMO_TITLE");?>
        </span>
    </div>
    <?php
        foreach ($eventos as $evento) {
            if ($evento->capituloId) {
                $controller->setData("capitulo", new Capitulo($evento->capituloId));
                echo $controller->view("modules.capitulo-mini", "programas");
            }
        }
    ?>
    <div class='col-md-6'></div>
    <div class="col-md-6 ver-todas-web" style="margin-top: 30px;">
        <?=Language::translate("VIEW_TVDIRECTO_VER_PARRILLA");?>&nbsp;&nbsp;<a href="<?=Url::site("parrillas");?>"><div class="circulo-azul">+</div></a>
    </div>
<?php } ?>
