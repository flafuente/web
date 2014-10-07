<?php 
defined('_EXE') or die('Restricted access');

$config = Registry::getConfig();
$hashtag = $config->get("twitterHashtag") ? $config->get("twitterHashtag") : "#TriboTv";


if(isset($_SESSION["lastTW"])){
  /*METER condicion where fecha > date("Y-m-d H:i:s", $_SESSION["lastTW"]);
  en la sentencia de abajo!*/
}
$tweets = Tweet::select(array("hashtag" => $hashtag, "order" => "fecha", "orderDir" => "DESC"), 50); 



if (count($tweets)) {
    foreach ($tweets as $tweet) {
        TwitterHelper::showTweet($tweet);
    }
}
?>