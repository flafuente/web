<?php
include_once("twitteroauth.php"); //Path to twitteroauth library you downloaded in step 3
$twitteruser = "homelyst"; //user name you want to reference
$notweets = 3; //how many tweets you want to retrieve
$consumerkey = "M8LPRrfMlVSgbqmiY39d6w"; //Noted keys from step 2
$consumersecret = "oV9StQWszT1HhyOSrBk2cZhe5RuUb6MDKXbvzhHVc"; //Noted keys from step 2
$accesstoken = "552317085-teYYibh7nL1veabhF3BsMzbhLqxZn9BnvnXjbn1M"; //Noted keys from step 2
$accesstokensecret = "Ch0OmXMy3Jk2RAVsqnSYHyjpYBmTEOw4BWAZGHk"; //Noted keys from step 2

function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
  $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
  return $connection;
}

$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);

$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&count=".$notweets);
$tweets = json_encode($tweets);
//echo "<pre>";
echo '{"response":{"statuses":[{"metadata":{"result_type":"recent","iso_language_code":"en"},';
echo substr($tweets, 2);
echo ',"search_metadata":{"completed_in":0.022,"max_id":3.75472363792e+17,"max_id_str":"375472363791720448","next_results":"?max_id=375472363791720447&q=from%3Alemonstand&count=1&include_entities=1","query":"from%3Alemonstand","refresh_url":"?since_id=375472363791720448&q=from%3Alemonstand&include_entities=1","count":1,"since_id":0,"since_id_str":"0"}},"message":false}';
//echo "</pre>";
//$arrtw = json_decode($tweets, true);
//$arrtw = $arrtw[0];		
?>