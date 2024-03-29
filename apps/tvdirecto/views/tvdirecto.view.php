<?php defined('_EXE') or die('Restricted access'); ?>

<script type="text/javascript" src="<?=Url::template('/js/player.js');?>"></script>

<div class='col-md-12 serie_info'>
    <div class="col-md-12 video">
        <div id="player">
            <div id='video_player'></div>
        </div>
        <div id="non-playable" style="display: none;">
            <img src="<?=Url::template("img/nophotovideo.png");?>">
        </div>
    </div>

    <!-- Ahora -->
    <div id="directoAhora">
        <?php $controller->setData("evento", $ahora); ?>
        <?php echo $controller->view("modules.ahora"); ?>
    </div>

    <!-- Próximos capitulos -->
    <div id="directoProximos">
        <?php if (count($proximos)) { ?>
            <?php $controller->setData("eventos", $proximos); ?>
            <?php echo $controller->view("modules.proximos"); ?>
        <?php } ?>
    </div>
</div>

<script>
    $(document).ready(function () {
        setInterval(function () {
            refreshDirecto();
        }, 60 * 1000);
    });

    function refreshDirecto()
    {
        $.ajax({
            type: "POST",
            url: "<?=Url::site('tvdirecto/refresh/');?>",
            dataType: "json"
        }).done(function (data) {
            $("#directoAhora").html(data.data.html.ahora);
            $("#directoProximos").html(data.data.html.proximos);
            if (data.data.hidePlayer == true) {
                $("#video_player").hide();
                $("#non-playable").show();
            } else {
                $("#video_player").show();
                $("#non-playable").hide();
            }
        });
    }

    var isMac = navigator.platform.toUpperCase().indexOf('MAC')>=0;
    $(document).ready(function () {
        showPlayer();
    });
    $( window ).resize(function () {
        if (!isMac) {
            showPlayer();
        }
    });
    function showPlayer()
    {
        if ($(window).width() < 600) {
            wdt = ($(window).width()-3);
            hgt = (($(window).width()-4)/1.4);
        } else {
            wdt = 570;
            hgt = 410;
        }
        OVERON_Player.init({
            width: wdt,
            height: hgt,
            container: 'video_player',
            stream: 'http://tribotv-ch01-live-cdn1-hls.streaming.overon.es/tribotv/channel01/tribotv/tribotv.m3u8'
        });
    }
</script>
