<?php defined('_EXE') or die('Restricted access');?>
<?php
$videoInfo = new stdClass();
$videoInfo->urlCategoria = "cultura";
$videoInfo->categoria = "Cultura";
$videoInfo->titulo = $video->titulo;
$videoInfo->ciudad = "Madrid";
$videoInfo->autor = "Juan Carlos Recife";
$videoInfo->fecha = date("d/m/Y", strtotime($video->dateInsert));
$videoInfo->hora = date("H:i", strtotime($video->dateInsert));
$videoInfo->likes = number_format(rand(5, 999999), 0, ",", ".");
$videoInfo->reproducciones = number_format(rand(9999, 99999999), 0, ",", ".");
$videoInfo->isMyfav = false;
$videoInfo->texto = $video->texto;

/*
Video Object ( [id] => 88 
               [userId] => 8 
               [estadoId] => 1 
               [estadoCdnId] => 3 
               [cdnId] => rnscors9n2 
               [thumbnail] => http://embed.wistia.com/deliveries/cfc1a9e01374ef8e16556ebf594eed082d53095e.jpg?image_crop_resized=640x360&video_still_time=14 
               [categoriaId] => 1 
               [titulo] => Fauna 
               [descripcion] => salvaje 
               [texto] => animales salvajes 
               [comunidadId] => 
               [localizacion] => 
               [long] => 
               [lat] => 
               [videoArchivoId] => 86 
               [visitas] => 4 
               [dateInsert] => 2014-09-14 14:08:30 
               [dateUpdate] => 2014-09-15 18:45:57 
               [estadosCss] => Array ( [0] => default [1] => success [2] => danger ) 
               [estados] => Array ( [0] => No publicado [1] => Publicado ) 
               [estadosCdn] => Array ( [0] => Pendiente [1] => Subiendo [2] => En conversión [3] => Finalizada [4] => Error ) 
               [className] => Video 
               [dbTable] => videos 
               [reservedVars] => Array ( [0] => className [1] => dbTable [2] => reservedVars [3] => reservedVarsChild [4] => idField ) 
               [reservedVarsChild] => Array ( [0] => estados [1] => estadosCss [2] => estadosCdn ) 
               [idField] => id ) 
*/
?>
<div class='col-md-12 serie_info'>
    <div class="col-md-12 video">
        <?php HTML::wistiaPlayer($video->cdnId, 558, 314); ?>
    </div>
<!-- Info -->
    <div class="video-info">

        <!-- Breadcrumb -->
        <div class="col-md-12 vd-ruta">
            Tribo News -
            <a href="<?=Url::site($videoInfo->urlCategoria);?>">
                <?=Helper::sanitize($videoInfo->categoria);?>
            </a>
        </div>

        <!-- Capítulo -->
        <div class="col-md-8">
            <div class="vd-capitulo">
                <?=Helper::sanitize($videoInfo->titulo);?>
            </div>
            <div style="clear: both;"></div>
            <div class="vd-capituloInfo">
            	En <span><?=Helper::sanitize($videoInfo->ciudad);?></span> por <strong><?=Helper::sanitize($videoInfo->autor);?></strong> | <span><?=Helper::sanitize($videoInfo->fecha);?></span> a las <strong><?=Helper::sanitize($videoInfo->hora);?></strong>
            </div>
        </div>

        <!-- Likes -->
        <div class="col-md-4">
            <div class="sq_num">
                <span>
                    <?=Helper::sanitize($videoInfo->likes);?>
                </span>
                <?php if ($videoInfo->isMyfav) { ?>
                    <i class="fa fa-heart like"></i>
                <?php } else { ?>
                    <i class="fa fa-heart-o like"></i>
                <?php } ?>
            	<div style="clear: both;"></div>
            	<span><?=Helper::sanitize($videoInfo->reproducciones);?> reproducciones</span>
            </div>
        </div>
        <!-- Descripción -->
        <div class="col-md-12 video-desc">
            <?=Helper::sanitize($videos->texto);?>
        </div>
        <div style="clear: both;"></div>
    </div>
    <br /><br />
    <div class='title-line'>
        <span>NOTICIAS RELACIONADAS</span>
    </div>
	<?php
	    if (count($relaccionadas)) {
	        foreach ($relaccionadas as $relaccionada) {
	            $controller->setData("proximo", $proximo);
	            echo $controller->view("modules.video-mini", "programas");
	        }
	    }
	?>




    

</div>

<!-- Like/Unlike -->
<script>

    var likes = parseInt($(".sq_num span:first-child").html());

    $(document).on('click', '.like', function (e) {
        if ($(this).hasClass("fa-heart-o")) {
            like(<?=$video->id;?>);
        } else {
            unlike(<?=$video->id;?>);
        }
    });

    function like(videoId)
    {
        $.ajax("<?=Url::site("tribonews/like");?>/" + videoId).done(function () {
            $(".like").removeClass("fa-heart-o");
            $(".like").addClass("fa-heart");
            likes++;
            updateLikesCounter();
        });
    }

    function unlike(videoId)
    {
        $.ajax("<?=Url::site("tribonews/unlike");?>/" + videoId).done(function () {
            $(".like").addClass("fa-heart-o");
            $(".like").removeClass("fa-heart");
            likes--;
            updateLikesCounter();
        });
    }

    function updateLikesCounter()
    {
        $(".sq_num span:first-child").html(likes)
    }

</script>
