<?php defined('_EXE') or die('Restricted access'); ?>

<?php
$comentarioEjemplo = new stdClass();
$comentarioEjemplo->autor = $user->username;
$comentarioEjemplo->thumb = $user->getFotoUrl();
$comentarioEjemplo->hace = rand(0, 30)." dias";
$comentarioEjemplo->texto = "Buenas:
                            <br /><br />
                            Soy un exprogramador de webs que, por cuestiones laborales, tuvo que dejar de programar.
                            <br /><br />
                            Ahora me surge la necesidad de crearme una mini aplicación web consistente básicamente en consultas a una base de datos, inserción, eliminado ... e informes y exportación a excel y PDF.
                            <br /><br />
                            Me gustaría que fuese algo superfluido. Recuerdo hace unos años cuando programaba con Ajax que aquello iba cañón.
                            <br /><br />
                            Conociendo éstas necesidades (aparte de que sea algo con una curva de aprendizaje) ... Qué componente/framework me recomendais?
                            <br /><br />
                            Gracias anticipadas.";
?>
<div class='title-line title-line-left'>
    <span>FORO TRIBER > <?=Helper::sanitize($comentario->titulo); ?></span>
</div>
<div class='col-md-12'>
    <div class="square-info-comentario">
    	<div class='col-md-9'>
    		<div class="col-md-3 foro_temas_icono" style="padding-top: 13px;">
	            <img src="<?=Helper::sanitize($comentario->thumb); ?>" class="img-circle profpic big" />
	        </div>
	        <div class="col-md-9 foro_tema_info temas">
	            <h1><?=Helper::sanitize($comentario->titulo); ?></h1>
	            <h2><strong>creado</strong> hace <strong><?=Helper::sanitize($comentario->tiempo); ?></strong> por <span><?=Helper::sanitize($comentario->creador); ?></span></h2>
	        </div>
    	</div>
    	<div class='col-md-3 ntemas nopaddingI'>
    		<button class="btn btn-tribo-blue" style="width: 100%; height: 50px;">Responder</button>
            <button class="btn btn-tribo-grey" style="width: 100%; height: 50px;">Otros temas del triber</button>
    	</div>
    </div>
    <div style="clear: both;"></div>
    <div class="col-md-offset-3"></div>
    <div class='col-md-9 foro-comentario foro-shadow'>
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
    <div style="clear: both;"></div>
    <?php
    $comentarios = array($comentarioEjemplo, $comentarioEjemplo, $comentarioEjemplo, $comentarioEjemplo);
    foreach($comentarios as $comentario){
        $controller->setData("comentario", $comentario);
        echo $controller->view("modules.comentario");
    }
    ?>
</div>