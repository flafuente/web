<?php defined('_EXE') or die('Restricted access'); ?>

<?php
$temaEjemplo = new stdClass();
$temaEjemplo->titulo = "No sé como crear un post y no encuentro cómo borrarlos";
$temaEjemplo->autor = $user->username;
$temaEjemplo->thumb = $user->getFotoUrl();
$temaEjemplo->lastcomment = rand(0, 60)." minutos";
$temaEjemplo->lastcomment_autor = "Felipe Blabla";
$temaEjemplo->lasttribers = Array($user->getFotoUrl(), $user->getFotoUrl(), $user->getFotoUrl(), $user->getFotoUrl());
$temaEjemplo->ntribers = 10;
?>
<div class='title-line title-line-left'>
    <span>FORO TRIBER</span>
</div>
<div class='col-md-12'>
    <div class="square-info-tema">
    	<div class='col-md-9'>
    		<div class="col-md-1 foro_temas_icono">
	            <img src="<?=Helper::sanitize($seccion->icono); ?>" />
	        </div>
	        <div class="col-md-11 foro_tema_info temas">
	            <h1><?=Helper::sanitize($seccion->titulo); ?></h1>
	            <h2><?=Helper::sanitize($seccion->descripcion); ?></h2>
	        </div>
    	</div>
    	<div class='col-md-3 ntemas'>
    		<?=Helper::sanitize($seccion->ntemas); ?> temas
    		<br />
    		<span id="open_new_tema">Abrir nuevo tema</span>
    	</div>
    </div>
    <div class="new_temaforo col-md-12">
        <div class="col-md-2">
                <img src="<?=Helper::sanitize($user->getFotoUrl()); ?>" class="img-circle profpic big" />
        </div>
        <div class="col-md-10">
            <form method="POST" action="">
                <label>Seccion del foro:</label>
                <?=HTML::select("seccionId", $foros, $_REQUEST["seccionId"], array(), array("display" => "Selecciona un foro"), array()); ?>
                <div style="clear: both;"></div>
                <label>Título del tema:</label>
                <input type="text" class="form-control" id="titulotema" name="titulotema" placeholder="Escribe el titulo del tema" value="" />
                <div style="clear: both;"></div>
                <label>Cuerpo de texto:</label>
                <textarea class="form-control" id="textotema" name="textotema"></textarea>
                <div style="clear: both;"></div><br />
                <button class="btn btn-tribo-blue" style="float: right;">Publicar tema</button>
            </form>
        </div>
    </div>
    <?php
    $temas = array($temaEjemplo, $temaEjemplo, $temaEjemplo, $temaEjemplo);
    foreach($temas as $tema){
        $controller->setData("tema", $tema);
        echo $controller->view("modules.tema");
    }
    ?>
</div>