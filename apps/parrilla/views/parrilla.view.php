<?php defined('_EXE') or die('Restricted access');?>

<div class='title-line'>
    <span>Parrilla Completa</span>
</div>
<div class="row">
    <div class="fechas slider center">
    <?php
    $dias = Array("1" => "Lunes",
                  "2" => "Martes",
                  "3" => "Miercoles",
                  "4" => "Jueves",
                  "5" => "Viernes",
                  "6" => "Sabado",
                  "7" => "Domingo");
    $meses = Array("1" => "Enero",
                  "2" => "Febrero",
                  "3" => "Marzo",
                  "4" => "Abril",
                  "5" => "Mayo",
                  "6" => "Junio",
                  "7" => "Julio",
                  "8" => "Agosto",
                  "9" => "Septiembre",
                  "10" => "Octubre",
                  "11" => "Noviembre",
                  "12" => "Diciembre");
    $hoy = strtotime(date("Y-m-d", strtotime("-3 days")));
    for ($x=0; $x<7; $x++) {
        $diaSuma = $x*(60*60*24);
        ?>
        <div class="seldateparr <?php if($x==3) echo "datesel"; ?> " fecha-parrilla="<?=date("Y-m-d", $hoy+$diaSuma);?>">
            <span class="p_dia"><?=$dias[date("N", $hoy+$diaSuma)]; ?></span>
            <br />
            <span class="p_mes"><?=date("d", $hoy+$diaSuma); ?> de <?=$meses[date("n", $hoy+$diaSuma)]; ?></span>
        </div>
        <?php
    }

    ?>
    </div>
    <div style="clear: both;"></div>
    <div class="parrilla_big" id="parr_content">
    </div>
    <div id="loading"></div>
</div>

<link rel="stylesheet" type="text/css" href="<?=Url::template("css/slick.css");?>"/>
<script type="text/javascript" src="<?=Url::template("js/slick.min.js");?>"></script>
<script>
    $( document ).ready(function () {
        $('.center').slick({
          arrows: false,
          centerMode: false,
          centerPadding: '60px',
          slidesToShow: 6,
          responsive: [
            {
              breakpoint: 768,
              settings: {
                arrows: true,
                centerMode: true,
                centerPadding: '40px',
                slidesToShow: 3
              }
            },
            {
              breakpoint: 480,
              settings: {
                arrows: true,
                centerMode: true,
                centerPadding: '40px',
                slidesToShow: 1
              }
            }
          ]
        });

        $("#loading").css("display", "initial");
        $.ajax({
            type: "POST",
            data: {fecha: "<?=date('Y-m-d');?>"},
            url: "<?=Url::site('parrilla/today/');?>",
            dataType: "json"
        }).done(function (data) {
            $("#parr_content").html(data["data"]["html"]);
            $("#loading").css("display", "none");
        });

        return false;
    });

    $(document).on("click",".seldateparr",function () {
        $(".seldateparr").removeClass("datesel");
        $(this).addClass("datesel");

        fecha = $(this).attr("fecha-parrilla");
        $("#loading").css("display", "initial");

        $.ajax({
            type: "POST",
            data: {fecha: fecha},
            url: "<?=Url::site('parrilla/today/');?>",
            dataType: "json"
        }).done(function (data) {
            $("#parr_content").html(data["data"]["html"]);
            $("#loading").css("display", "none");
            $( document ).ready(function () {
                $(".parrilla_big").mCustomScrollbar({
                    scrollButtons:{
                        enable:true
                    },
                    theme:"dark"
                });
            });
        });

        return false;
    });

</script>
