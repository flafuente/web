<?php defined('_EXE') or die('Restricted access'); ?>

<a class='rsep contact' href='#'>
    <img src='<?=Url::template("/img/contact.png");?>' title='Contacta' />
</a>
<div class="contact_form" style="display: none;">
    <div class="forgot col-md-12"><img style="float: left;" src='<?=Url::template("/img/contact.png");?>' title='Login' /><h1>&nbsp;&nbsp;&nbsp;CONTACTA CON NOSOTROS</h1></div>
    <div style="clear: both;"></div>
    <br />
    <form class="l_form" action="" method="POST">
        <div class="col-md-12"><input class="form-control" type="text" name="name" placeholder="Nombre" value="" /></div>
        <div class="col-md-12"><input class="form-control" type="text" name="email" placeholder="Email"></div>

        <div class="col-md-12">
            <select class="form-control" name="withwho">
                <option value="all">Con quien quieres contactar</option>
                <?php
                for ($x=0; $x<10; $x++) {
                    ?><option value="<?= ($x+1); ?>">Persona <?= ($x+1); ?></option><?php
                }
                ?>
            </select>
        </div>
        <div class="col-md-12">
            <textarea class="form-control" name="mensaje" placeholder="Mensaje"></textarea>
        </div>
        <div class="forgot col-md-8"></div>
        <div class="col-md-4 l-right"><button type="submit" class="btn btn-tribo-blue ladda-button">Enviar</button></div>
        <div style="clear: both;"></div>
    </form>
</div>
