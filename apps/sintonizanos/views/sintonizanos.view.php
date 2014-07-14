<?php defined('_EXE') or die('Restricted access');

?>
<div class='col-md-12 serie_info'>
    <img src="<?=Url::template("img/sintonizanos/sintonizanos.png");?>" alt="Sintonízanos" />
    <div class="square-info">
        <div class="grey">
            ¿DÓNDE PUEDES VER TRIBO?
        </div>
        <div class="canalesd">
       <?php
       /*Remplazar por llamada a BBDD*/
       $canales = Array(
                        0 => Array(
                            "id_key" => "canaplus",
                            "name" => "Canal+",
                            "url" => "http://canalplus.com",
                            "imagen" => "canalplus.png"
                            ),
                        1 => Array(
                            "id_key" => "movistar",
                            "name" => "Movistar TV",
                            "url" => "http://movistar.com",
                            "imagen" => "movistartv.png"
                            ),
                        2 => Array(
                            "id_key" => "ono",
                            "name" => "ONO",
                            "url" => "http://ono.com",
                            "imagen" => "ono.png"
                            ),
                        3 => Array(
                            "id_key" => "britel",
                            "name" => "Britel",
                            "url" => "http://britel.com",
                            "imagen" => "britel.png"
                            ),
                        4 => Array(
                            "id_key" => "euskaltel",
                            "name" => "Euskaltel",
                            "url" => "http://euskaltel.com",
                            "imagen" => "euskaltel.png"
                            ),
                        5 => Array(
                            "id_key" => "rtv",
                            "name" => "R",
                            "url" => "http://r.com",
                            "imagen" => "r.png"
                            ),
                        6 => Array(
                            "id_key" => "telecable",
                            "name" => "Telecable",
                            "url" => "http://telecable.com",
                            "imagen" => "telecable.png"
                            ),
                        7 => Array(
                            "id_key" => "tdt",
                            "name" => "TDT",
                            "url" => "http://tdt.com",
                            "imagen" => "tdt.png"
                            ),
                        );
        /*La imagen ha de ser de 336x71.... pero el 336 se divide en dos (168), ver ejemplo*/
       for($x=0; $x<count($canales); $x++){
            ?>
            <style>
                #<?= $canales[$x]["id_key"]; ?>{
                    background-image: url("<?=Url::template("img/sintonizanos/".$canales[$x]["imagen"]);?>");
                }
                #<?= $canales[$x]["id_key"]; ?>:hover{
                    background-position: 0px;
                }
            </style>
            <a href="<?= $canales[$x]["url"]; ?>" target="_blank"><div class="cadena" id="<?= $canales[$x]["id_key"]; ?>"></div></a>
            <?php
       }
       ?>
        </div>
       <div style="clear: both;"></div>
    </div>
</div>