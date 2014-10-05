<?php defined('_EXE') or die('Restricted access'); ?>

<?php $config = Registry::getConfig(); ?>
<?php $hashtag = $config->get("twitterHashtag") ? $config->get("twitterHashtag") : "#TriboTv"; ?>


<?php
$tweets = Tweet::select(array("hashtag" => $hashtag, "order" => "fecha", "orderDir" => "DESC"), 50);
?>

<div class="twitter">
    <div class="titulo">
        <i class="fa fa-twitter"></i>
        &nbsp;&nbsp;&nbsp;<?=$hashtag;?>
    </div>
    <div class="tweets">
        <?php if (count($tweets)) { ?>
            <?php foreach ($tweets as $tweet) { ?>
                <?php TwitterHelper::showTweet($tweet); ?>
            <?php } ?>
        <?php } ?>
    </div>
</div>

<script>
    $(window).load(function () {
        $(".tweets").mCustomScrollbar({
            scrollButtons:{
                enable:true
            },
            theme:"dark"
        });
    });
</script>
