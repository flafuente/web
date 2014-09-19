<?php defined('_EXE') or die('Restricted access'); ?>

<?php
$comentarioEjemplo = new stdClass();
$comentarioEjemplo->titulo = "No sé como crear un post y no encuentro cómo borrarlos";
$comentarioEjemplo->autor = $user->username;
$comentarioEjemplo->thumb = $user->getFotoUrl();
$comentarioEjemplo->lastcomment = rand(0, 60)." minutos";
$comentarioEjemplo->lastcomment_autor = "Felipe Blabla";
$comentarioEjemplo->lasttribers = Array($user->getFotoUrl(), $user->getFotoUrl(), $user->getFotoUrl(), $user->getFotoUrl());
$comentarioEjemplo->ntribers = 10;
?>
<div class='title-line title-line-left'>
    <span>FORO TRIBER > <?=Helper::sanitize($comentario->titulo); ?></span>
</div>
<div class='col-md-12'>
    <div class="square-info-comentario">
    	<div class='col-md-9'>
    		<div class="col-md-1 foro_temas_icono">
	            <img src="<?=Helper::sanitize($comentario->thumb); ?>" class="img-circle profpic big" />
	        </div>
	        <div class="col-md-11 foro_tema_info temas">
	            <h1><?=Helper::sanitize($comentario->titulo); ?></h1>
	            <h2><strong>creado</strong> hace <strong><?=Helper::sanitize($comentario->tiempo); ?></strong> por <span><?=Helper::sanitize($comentario->creador); ?></span></h2>
	        </div>
    	</div>
    	<div class='col-md-3 ntemas'>
    		<button class="btn btn-tribo-blue">Responder</button>
            <button class="btn btn-tribo-grey">Otros temas del triber</button>
    	</div>
    </div>
    <div>
        Buenas:
        <br /><br />
        Soy un exprogramador de webs que, por cuestiones laborales, tuvo que dejar de programar.
        <br /><br />
        Ahora me surge la necesidad de crearme una mini aplicación web consistente básicamente en consultas a una base de datos, inserción, eliminado ... e informes y exportación a excel y PDF.
        <br /><br />
        Me gustaría que fuese algo superfluido. Recuerdo hace unos años cuando programaba con Ajax que aquello iba cañón.
        <br /><br />
        Conociendo éstas necesidades (aparte de que sea algo con una curva de aprendizaje) ... Qué componente/framework me recomendais?
        <br /><br />
        Gracias anticipadas.
    </div>
    <?php
    $comentarios = array($comentarioEjemplo, $comentarioEjemplo, $comentarioEjemplo, $comentarioEjemplo);
    foreach($comentarios as $comentario){
        $controller->setData("comentario", $comentario);
        echo $controller->view("modules.comentario");
    }
    ?>
</div>