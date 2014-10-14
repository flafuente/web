<?php defined('_EXE') or die('Restricted access'); ?>
<?php
$stl = "";
if (Registry::getUser()->id) {
    $stl = "margin-top: -40px;left: 77px;";
}
?>
<a class='rsep contact' href='#'>
    <img src='<?=Url::template("/img/contact.png");?>' title='<?=Language::translate("VIEW_TEMPLATE_CONTACTO_CONTACTA");?>' />
</a>
<div class="contact_form" style="display: none;<?=$stl;?>">
    <div class="forgot col-md-12"><img class="imgmdl" src='<?=Url::template("/img/contact.png");?>' title='Login' /><h1>&nbsp;&nbsp;&nbsp;<?=Language::translate("VIEW_TEMPLATE_CONTACTO_TITLE");?></h1></div>
    <div style="clear: both;"></div>
    <br />
    <form class="l_form ajax" role="form" method="post" name="mainForm" id="mainForm" action="<?=Url::site("contacto/enviar");?>">
        <!-- Nombre -->
        <div class="col-md-12">
            <input class="form-control" type="text" name="nombre" placeholder="<?=Language::translate("VIEW_TEMPLATE_CONTACTO_NOMBRE");?>" value="" />
        </div>
        <!-- Email -->
        <div class="col-md-12">
            <input class="form-control" type="text" name="email" placeholder="<?=Language::translate("VIEW_TEMPLATE_CONTACTO_EMAIL");?>">
        </div>
        <?php $contactos = Contacto::select(array("visible" => true, "order" => "nombre")); ?>
        <?php if (count($contactos)) { ?>
            <!-- Contacto -->
            <div class="col-md-12">
                <?=HTML::select("contactoId", $contactos, null, null, null, array("display" => "nombre")); ?>
            </div>
        <?php } ?>
        <!-- Mensaje -->
        <div class="col-md-12">
            <textarea class="form-control" name="mensaje" placeholder="<?=Language::translate("VIEW_TEMPLATE_CONTACTO_MENSAJE");?>"></textarea>
        </div>
        <div class="forgot col-md-8"></div>
        <!-- Buttons -->
        <div class="col-md-4 l-right">
            <?=HTML::formButton("btn-tribo-blue", null, Language::translate("BTN_SEND"), array(
                    "data-app" => "contacto",
                    "data-action" => "enviar"
                )
            );?>
        </div>
        <div style="clear: both;"></div>
    </form>
</div>
