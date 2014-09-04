<?php 
print_r($_POST);
?>

<div class="col-md-6 nopaddingI">
    Miniarura
</div>
<div class="col-md-6 nopaddingI">
<i class="fa fa-long-arrow-right btnazul btnazul-ico" style="top: 45px; color: #FFFFFF;"></i>&nbsp;&nbsp;<input id="viddis" type="file" value="Editar el Video" class="btnazul viddis" style="top: 45px;" />
<br /><br />
<i class="fa fa-long-arrow-right btnazul btnazul-ico" style="top: 45px; color: #FFFFFF;"></i>&nbsp;&nbsp;<input id="vidord" type="file" value="Cambiar la miniatura del Video" class="btnazul vidord" style="top: 45px;" />
</div>
<div class="col-md-3 nopaddingI">Nombre</div>
<div class="col-md-9 nopaddingI"><input type="text" value="" name="titulo" /></div>
<div style="clear: both;"></div>
<div class="col-md-3 nopaddingI">Ubicación</div>
<div class="col-md-9 nopaddingI"><input type="text" value="" name="ubicacion" /></div>
<div style="clear: both;"></div>
<div class="col-md-3 nopaddingI">Sección</div>
<div class="col-md-9 nopaddingI">
    <select name="seccion">
        <option value="1">Seccion 01</option>
        <option value="2">Seccion 02</option>
        <option value="3">Seccion 03</option>
        <option value="4">Seccion 04</option>
        <option value="5">Seccion 05</option>
        <option value="6">Seccion 06</option>
    </select>
</div>
<div style="clear: both;"></div>
<div class="col-md-3 nopaddingI">Descripción</div>
<div class="col-md-9 nopaddingI"><textarea type="text" name="descripcion"></textarea></div>
<div style="clear: both;"></div>
<div class="col-md-3 nopaddingI">Tags</div>
<div class="col-md-9 nopaddingI"><input type="text" value="" name="tags" /></div>
<div style="clear: both;"></div>
<div class="col-md-3 nopaddingI">Adjuntos</div>
<div class="col-md-9 nopaddingI"><input type="text" value="" name="adjuntos" /></div>
<div style="clear: both;"></div>
<button type="submit" class="btn-tribo-grey btn ladda-button" style="float: left;">Cancelar</button>
<button type="submit" class="btn-tribo-blue btn ladda-button" style="float: right;"><i class="fa fa-check"></i>&nbsp;&nbsp;Guardar Cambios</button>