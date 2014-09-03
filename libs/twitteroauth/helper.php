<?php

class TwitterHelper
{
    public static function showTweet($data)
    {
        $fecha = HTML::relativeDate($data["created_at"]);
        $nombre = $data["user"]["name"];
        $usuario = "@".$data["user"]["screen_name"];
        $foto = $data["user"]["profile_image_url"];
        $tweet = $data["text"];
        $nret = $data["retweet_count"];

        /*Vemos si es retweet o no*/
        if (isset($data["retweeted_status"]["user"]["name"]) && strlen($data["retweeted_status"]["user"]["name"])>2) {
            $nombre = $data["retweeted_status"]["user"]["name"];
            $foto = $data["retweeted_status"]["user"]["profile_image_url"];
        }

        if (isset($data["retweeted_status"]["user"]["screen_name"]) && strlen($data["retweeted_status"]["user"]["screen_name"])>2) {
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
                <?php echo self::link_it($usuario); ?>
            </div>
            <div style="clear: both;"></div>
            <div class="texto">
                <?php echo self::link_it($tweet); ?>
            </div>
            <div style="clear: both;"></div>
            <div class="nret">
                <?php echo $nret; ?> RETWEETS
            </div>
        </div>
        <?php
    }

    public static function link_it($text)
    {
        $text= preg_replace("/(^|[\n ])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a href=\"$3\" target=\"_blank\" >$3</a>", $text);
        $text= preg_replace("/(^|[\n ])([\w]*?)((www|ftp)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href=\"http://$3\" target=\"_blank\" >$3</a>", $text);
        $text= preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href=\"mailto:$2@$3\" target=\"_blank\">$2@$3</a>", $text);
        $text= preg_replace("/@(\w+)/", '<a href="http://www.twitter.com/$1" target="_blank">@$1</a>', $text);
        $text= preg_replace("/\#(\w+)/", '<a href="https://twitter.com/search?q=$1&src=typd" target="_blank">#$1</a>',$text);

        return $text;
    }

}
