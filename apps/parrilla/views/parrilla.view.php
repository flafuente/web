<?php defined('_EXE') or die('Restricted access');?>

<div class='title-line'>
    <span>
      <?=Language::translate("VIEW_PARRILLA_PARRILLA_TITLE");?>
    </span>
</div>
<div class="row">
    <div class="fechas slider center">
    <?php
    $dias = Array("1" => Language::translate("SEMANA_LUNES"),
                  "2" => Language::translate("SEMANA_MARTES"),
                  "3" => Language::translate("SEMANA_MIERCOLES"),
                  "4" => Language::translate("SEMANA_JUEVES"),
                  "5" => Language::translate("SEMANA_VIERNES"),
                  "6" => Language::translate("SEMANA_SABADO"),
                  "7" => Language::translate("SEMANA_DOMINGO"));
    $meses = Array("1" => Language::translate("MESES_ENERO"),
                  "2" => Language::translate("MESES_FEBRERO"),
                  "3" => Language::translate("MESES_MARZO"),
                  "4" => Language::translate("MESES_ABRIL"),
                  "5" => Language::translate("MESES_MAYO"),
                  "6" => Language::translate("MESES_JUNIO"),
                  "7" => Language::translate("MESES_JULIO"),
                  "8" => Language::translate("MESES_AGOSTO"),
                  "9" => Language::translate("MESES_SEPTIEMBRE"),
                  "10" => Language::translate("MESES_OCTUBRE"),
                  "11" => Language::translate("MESES_NOVIEMBRE"),
                  "12" => Language::translate("MESES_DICIEMBRE"));
    $hoy = strtotime(date("Y-m-d", strtotime("-3 days")));
    for ($x=0; $x<7; $x++) {
        $diaSuma = $x*(60*60*25);
        ?>
        <div class="seldateparr <?php if($x==3) echo "datesel"; ?> " fecha-parrilla="<?=date("Y-m-d", $hoy+$diaSuma);?>">
            <span class="p_dia">
              <?=$dias[date("N", $hoy+$diaSuma)]; ?>
            </span>
            <br />
            <span class="p_mes"><?=date("d", $hoy+$diaSuma); ?> <?=Language::translate("SEMANA_MES_CONCAT");?> <?=$meses[date("n", $hoy+$diaSuma)]; ?></span>
        </div>
        <?php
    }

    ?>
    </div>
    <div style="clear: both;"></div>
    <div class="parrilla_big" id="parr_content">
      <?php
        if (count($eventos)) {
            foreach ($eventos as $evento) {
                $controller->setData("evento", $evento);
                echo $controller->view("modules.evento");
            }
        }
      ?>
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
