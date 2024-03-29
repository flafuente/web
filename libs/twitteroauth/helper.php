<?php

class TwitterHelper
{
    public static function showTweet($data)
    {
        $fecha = HTML::relativeDate($data->fecha);
        $nombre = $data->nombre;
        $usuario = "@".$data->usuario;
        $foto = $data->foto;
        $tweet = $data->tweet;
        $nret = $data->nret;
        $idtweet = $data->id;

        /*Vemos si es retweet o no*/
        if (isset($data->rt_name) && strlen($data->rt_name)>2) {
            $nombre = $data->rt_name;
            $foto = $data->rt_image;

            return false;
        }

        if (isset($data->rt_usuario) && strlen($data->rt_usuario)>2) {
            $usuario = "@".$data->rt_usuario;
        }

        /*Impresion del tweet*/
        ?>
        <div class="tweet" id="t_<?=strtotime($data->fecha);?>">
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
        if(isset($_SESSION["lastTW"])){
            if(strtotime($data->fecha)>$_SESSION["lastTW"]) $_SESSION["lastTW"] = strtotime($data->fecha);
        }else{
            $_SESSION["lastTW"] = strtotime($data->fecha);
        }
    }

    public static function link_it($text)
    {
        $text= preg_replace("/(^|[\n ])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a href=\"$3\" target=\"_blank\" >$3</a>", $text);
        $text= preg_replace("/(^|[\n ])([\w]*?)((www|ftp)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href=\"http://$3\" target=\"_blank\" >$3</a>", $text);
        $text= preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href=\"mailto:$2@$3\" target=\"_blank\">$2$3</a>", $text);
        $text= preg_replace("/@(\w+)/", '<a href="http://www.twitter.com/$1" target="_blank">$1</a>', $text);
        $text= preg_replace("/\#(\w+)/", '<a href="https://twitter.com/search?q=$1&src=typd" target="_blank">#$1</a>',$text);

        return $text;
    }

}
