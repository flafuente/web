<?php

class Wistia
{

    private static $password = '';

    public static function init()
    {
        $config = Registry::getConfig();
        self::$password = $config->get("wistia_token");
    }

    public static function status($hash)
    {
        $url = "https://api.wistia.com/v1/medias/".$hash.".json?api_password=".self::$password;
        $result = self::curl($url);
        $json = json_decode($result);

        return $json;
    }

    private static function curl($url, $post = array())
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        if (!empty($post)) {
            curl_setopt($ch,CURLOPT_POST, 1);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $post);
        }
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
