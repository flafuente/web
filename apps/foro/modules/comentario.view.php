<?php defined('_EXE') or die('Restricted access'); ?>

<?php
/*
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
*/
?>
<div class="col-md-offset-1 col-md-11 nopaddingI foro-shadow foro-comment-container">
    <div class='col-md-2 foro-comentariocreador'>
        <img src="<?=Helper::sanitize($comentario->thumb); ?>" class="img-circle profpic big" />
        <?php
        if(rand(0,1) == 1){
            ?><br /><br /><span class="tag">MODERADOR</span><?php
        }
        ?>
    </div>
    <div class='col-md-10 foro-comentario'>
        por <span><?=Helper::sanitize($comentario->autor); ?></span> hace <strong><?=Helper::sanitize($comentario->hace); ?></strong>
        <br /><br />
        <?=($comentario->texto); ?>
    </div>
    <div class="left-arrow"></div>
</div>
<div style="clear: both;"></div>