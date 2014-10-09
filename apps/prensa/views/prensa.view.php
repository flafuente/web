<?php defined('_EXE') or die('Restricted access'); ?>

<?php
$notaEjemplo = new stdClass();
$notaEjemplo->icono = Url::template("img/pos_foto.png");
$notaEjemplo->titulo = "Titular";
$notaEjemplo->descripcion = "Breve sinopsis de las notiticias. Breve sinopsis de las notiticias. Breve sinopsis de las notiticias. Breve sinopsis de las notiticias. Breve sinopsis de las noticias";
$notaEjemplo->fecha = date("d / m / Y");
?>
<div class='col-md-12'>
    <div class="square-info-foro">
        <div class="grey" style="margin-bottom: 0px;">
            SALA DE PRENSA
            <div class="right">
                Ordenar por fecha
                <select style="color: black;">
                    <option>Ascendente</option>
                    <option>Descendente</option>
                </select>
            </div>
        </div>
    </div>
    <?php
    $notas = array($notaEjemplo, $notaEjemplo, $notaEjemplo, $notaEjemplo);
    foreach($notas as $nota){
        $controller->setData("nota", $nota);
        echo $controller->view("modules.notas");
    }
    ?>
    
</div>