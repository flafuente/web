<?php defined('_EXE') or die('Restricted access'); ?>

<?php $config = Registry::getConfig(); ?>
<?php $hashtag = $config->get("twitterHashtag") ? $config->get("twitterHashtag") : "#TriboTv"; ?>

<?php $tweets = Tweet::select(array("hashtag" => $hashtag, "order" => "fecha", "orderDir" => "DESC"), 50); ?>

<?php unset($_SESSION["lastTW"]); ?>

<div class="twitter">
    <div class="titulo">
        <i class="fa fa-twitter"></i>
        &nbsp;&nbsp;&nbsp;<?=$hashtag;?>
    </div>
    <div class="tweets">
        <div id="newTW"></div>
        <?php if (count($tweets)) { ?>
            <?php foreach ($tweets as $tweet) { ?>
                <?php TwitterHelper::showTweet($tweet); ?>
            <?php } ?>
        <?php } ?>
    </div>
</div>

<script>
    $( document ).ready(function () {
        $(".tweets").mCustomScrollbar({
            scrollButtons:{
                enable:true
            },
            theme:"dark"
        });
        var intervalo = setInterval(function () {
            $.ajax({
                url: '<?=Url::site("twitter/refresh");?>',
                method: 'get',
                dataType: 'json',
                success: function (data) {
                    $('#newTW').html(data.data.html + $('#newTW').html());
                },
                error: function () {
                    console.log('imposible conseguir nuevos tweets');
                }
            })
        }, 10000);

    });
</script>
