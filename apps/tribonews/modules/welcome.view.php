<?php defined('_EXE') or die('Restricted access');?>

<div class="modal fade" id="welcomeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 class="modal-title" id="myModalLabel">Bienvenido a Tribo!</h4>
            </div>
            <div class="modal-body">
                Hemos recibido tu solicitud, la plataforma se abrira en breves, te informaremos via email.
            </div>
        </div>
    </div>
</div>

<script>
    $('#welcomeModal').modal('show');
</script>
