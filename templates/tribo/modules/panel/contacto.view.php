<?php defined('_EXE') or die('Restricted access'); ?>

<a class='rsep contact' href='#'>
    <img src='<?=Url::template("/img/contact.png");?>' title='Contacta' />
</a>
<div class="contact_form" style="display: none;">
    <div class="forgot col-md-12"><img style="float: left;" src='<?=Url::template("/img/contact.png");?>' title='Login' /><h1>&nbsp;&nbsp;&nbsp;CONTACTA CON NOSOTROS</h1></div>
    <div style="clear: both;"></div>
    <br />
    <form class="l_form ajax" role="form" method="post" name="mainForm" id="mainForm" action="<?=Url::site("contacto/enviar");?>">
        <!-- Nombre -->
        <div class="col-md-12">
            <input class="form-control" type="text" name="nombre" placeholder="Nombre" value="" />
        </div>
        <!-- Email -->
        <div class="col-md-12">
            <input class="form-control" type="text" name="email" placeholder="Email">
        </div>
        <?php $secciones = Seccion::select(); ?>
        <?php if (count($secciones)) { ?>
            <!-- Sección -->
            <div class="col-md-12">
                <?=HTML::select("seccionId", $secciones, null, null, null, array("display" => "nombre")); ?>
            </div>
        <?php } ?>
        <!-- Mensaje -->
        <div class="col-md-12">
            <textarea class="form-control" name="mensaje" placeholder="Mensaje"></textarea>
        </div>
        <div class="forgot col-md-8"></div>
        <!-- Buttons -->
        <div class="col-md-4 l-right">
            <?=HTML::formButton("btn-tribo-blue", null, "Enviar", array(
                    "data-app" => "contacto",
                    "data-action" => "enviar"
                )
            );?>
        </div>
        <div style="clear: both;"></div>
    </form>
</div>
