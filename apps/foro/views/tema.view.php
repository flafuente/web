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
    		<span>Abrir nuevo tema</span>
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