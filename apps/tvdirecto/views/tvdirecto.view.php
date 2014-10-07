<?php defined('_EXE') or die('Restricted access'); ?>

<div class='col-md-12 serie_info'>
    <?php /*<div class="col-md-12 video">
        <script id="overon_main_script" type="text/javascript" src="http://overonocc.cdn.customers.overon.es/player/environment.js"></script>
        <div id='video_player'></div>
        <script>

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
                    stream: 'http://overon-apple-live.adaptive.level3.net/apple/overon/channel06/index.m3u8'
                });
            }
        </script>
    </div>*/?>

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
        });
    }
</script>
