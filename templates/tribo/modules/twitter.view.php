<?php defined('_EXE') or die('Restricted access'); ?>
	<!--
	<a class="twitter-timeline" href="https://twitter.com/pepocivs" data-widget-id="453902978185822208">Tweets por @pepocivs</a>
	<script>
		!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
	</script>
	-->
	<link href="<?=Url::template("js/scroll/jquery.mCustomScrollbar.css")?>" rel="stylesheet" />
	<script src="<?=Url::template("js/scroll/jquery.mCustomScrollbar.concat.min.js")?>"></script>
    <script>
            $(window).load(function(){
                $(".tweets").mCustomScrollbar({
                    scrollButtons:{
                        enable:true
                    },
                    theme:"dark"
                });
            });
    </script>
	<?php
	if(is_callable('curl_init')){

		include_once("templates/tribo/twitteroauth/twitteroauth.php"); //Path to twitteroauth library you downloaded in step 3
		$twitteruser = "Tribo_tv"; //user name you want to reference
		$notweets = 50; //how many tweets you want to retrieve
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

		$tweets = json_decode( json_encode($tweets), true);
		?>
		<div class="twitter">
			<div class="titulo"><i class="fa fa-twitter"></i>&nbsp;&nbsp;&nbsp;#Tribo</div>
			<div class="tweets">
				<?php
				//print_r($tweets);
				for($x=0; $x<count($tweets); $x++){
					showTweet($tweets[$x]);
				}
				?>

			</div>
		</div>



	<?php
	}

	function showTweet($data){
		$fecha = time_passed(strtotime($data["created_at"]));
		$nombre = $data["user"]["name"];
		$usuario = "@".$data["user"]["screen_name"];
		$foto = $data["user"]["profile_image_url"];
		$tweet = $data["text"];
		$nret = $data["retweet_count"];
		$responder = "";
		$retweet = "";
		$favorite = "";

		/*Vemos si es retweet o no*/
		if(isset($data["retweeted_status"]["user"]["name"]) && strlen($data["retweeted_status"]["user"]["name"])>2){
			$nombre = $data["retweeted_status"]["user"]["name"];
			$foto = $data["retweeted_status"]["user"]["profile_image_url"];
		}

		if(isset($data["retweeted_status"]["user"]["screen_name"]) && strlen($data["retweeted_status"]["user"]["screen_name"])>2){
			$usuario = "@".$data["retweeted_status"]["user"]["screen_name"];
		}

		/*Impresion del tweet*/
		?>
		<div class="tweet">
			<img class="imagen" src="<?php echo $foto; ?>" />
			<div class="tiempo">
				<?php echo $fecha; ?>
			</div>
			<div class="nombreuser">
				<?php echo $nombre; ?>
				<br />
				<?php echo link_it($usuario); ?>
			</div>
			<div style="clear: both;"></div>
			<div class="texto">
				<?php echo link_it($tweet); ?>
			</div>
			<div style="clear: both;"></div>
			<div class="nret">
				<?php echo $nret; ?> RETWEETS
			</div>
		</div>
		<?php
	}

	function link_it($text) { 
	    $text= preg_replace("/(^|[\n ])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a href=\"$3\" target=\"_blank\" >$3</a>", $text);
	    $text= preg_replace("/(^|[\n ])([\w]*?)((www|ftp)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href=\"http://$3\" target=\"_blank\" >$3</a>", $text);
	    $text= preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href=\"mailto:$2@$3\" target=\"_blank\">$2@$3</a>", $text);
    	$text= preg_replace("/@(\w+)/", '<a href="http://www.twitter.com/$1" target="_blank">@$1</a>', $text); 
   		$text= preg_replace("/\#(\w+)/", '<a href="https://twitter.com/search?q=$1&src=typd" target="_blank">#$1</a>',$text); 
	    return $text;
	}
	function time_passed($timestamp){
	    //type cast, current time, difference in timestamps
	    $timestamp      = (int) $timestamp;
	    $current_time   = time();
	    $diff           = $current_time - $timestamp;
	    
	    //intervals in seconds
	    $intervals      = array (
	        'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute'=> 60
	    );
	    
	    //now we just find the difference
	    if ($diff == 0)
	    {
	        return 'Justo ahora';
	    }    

	    if ($diff < 60)
	    {
	        return $diff == 1 ? $diff . ' segundo' : $diff . ' segundos';
	    }        

	    if ($diff >= 60 && $diff < $intervals['hour'])
	    {
	        $diff = floor($diff/$intervals['minute']);
	        return $diff == 1 ? $diff . ' minuto' : $diff . ' minutos';
	    }        

	    if ($diff >= $intervals['hour'] && $diff < $intervals['day'])
	    {
	        $diff = floor($diff/$intervals['hour']);
	        return $diff == 1 ? $diff . ' hora' : $diff . ' horas';
	    }    

	    if ($diff >= $intervals['day'] && $diff < $intervals['week'])
	    {
	        $diff = floor($diff/$intervals['day']);
	        return $diff == 1 ? $diff . ' dia' : $diff . ' dias';
	    }    

	    if ($diff >= $intervals['week'] && $diff < $intervals['month'])
	    {
	        $diff = floor($diff/$intervals['week']);
	        return $diff == 1 ? $diff . ' semana' : $diff . ' semanas';
	    }    

	    if ($diff >= $intervals['month'] && $diff < $intervals['year'])
	    {
	        $diff = floor($diff/$intervals['month']);
	        return $diff == 1 ? $diff . ' mes' : $diff . ' meses';
	    }    

	    if ($diff >= $intervals['year'])
	    {
	        $diff = floor($diff/$intervals['year']);
	        return $diff == 1 ? $diff . ' año' : $diff . ' años';
	    }
	}
	?>