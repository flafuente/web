
<?php if ($data["nombre"]) { ?>
    <p><strong>Nombre: </strong><?=Helper::sanitize($data["nombre"])?></p>
<?php } ?>

<?php if ($data["apellidos"]) { ?>
    <p><strong>Apellidos: </strong><?=Helper::sanitize($data["apellidos"])?></p>
<?php } ?>

<?php if ($data["email"]) { ?>
    <p><strong>Email: </strong><?=Helper::sanitize($data["email"])?></p>
<?php } ?>

<?php if ($data["telefono"]) { ?>
    <p><strong>Teléfono: </strong><?=Helper::sanitize($data["telefono"])?></p>
<?php } ?>

<?php if ($data["url"]) { ?>
    <p><strong>Url: </strong><?=Helper::sanitize($data["url"])?></p>
<?php } ?>

<?php $categoria = new Categoria($data["categoriaId"]); ?>
<?php if ($categoria->id) { ?>
    <p><strong>Categoría: </strong><?=Helper::sanitize($categoria->nombre)?></p>
<?php } ?>

<p><?=Helper::sanitize($data["mensaje"])?></p>
