<p><strong>Nombre: </strong><?=Helper::sanitize($data["nombre"])?></p>
<p><strong>Apellidos: </strong><?=Helper::sanitize($data["apellidos"])?></p>
<p><strong>Email: </strong><?=Helper::sanitize($data["email"])?></p>
<p><strong>Teléfono: </strong><?=Helper::sanitize($data["telefono"])?></p>
<p><strong>Url: </strong><?=Helper::sanitize($data["url"])?></p>
<p><strong>Categoría: </strong><?=Helper::sanitize($categoria->nombre)?></p>
<br>
<p><?=Helper::sanitize($data["mensaje"])?></p>
