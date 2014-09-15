<?php defined('_EXE') or die('Restricted access'); ?>

<?php $config = Registry::getConfig(); ?>
<?php $hashtag = $config->get("twitterHashtag") ? $config->get("twitterHashtag") : "#TriboTv"; ?>

<link href="<?=Url::template("js/scroll/jquery.mCustomScrollbar.css")?>" rel="stylesheet" />
<script src="<?=Url::template("js/scroll/jquery.mCustomScrollbar.concat.min.js")?>"></script>

<?php
$notweets = 50;
$connection = new TwitterOAuth(
    $config->get("twitter_key"),
    $config->get("twitter_secret"),
    $config->get("twitter_token"),
    $config->get("twitter_token_secret")
);
$params = array(
    "q" => $hashtag,
    "result_type" => "recent",
    "count" => $notweets,
);
$tweets = $connection->get("https://api.twitter.com/1.1/search/tweets.json", $params);
$tweets = json_decode( json_encode($tweets), true);
?>

<div class="twitter">
    <div class="titulo">
        <i class="fa fa-twitter"></i>
        &nbsp;&nbsp;&nbsp;<?=$hashtag;?>
    </div>
    <div class="tweets">
        <?php if (count($tweets["statuses"])) { ?>
            <?php foreach ($tweets["statuses"] as $tweet) { ?>
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
