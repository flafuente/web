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

    public static function searchMedia($filename)
    {
        $url = "https://api.wistia.com/v1/medias.json?api_password=".self::$password."&name=".urlencode($filename)."&type=Video";
        $result = self::curl($url);
        $json = json_decode($result);

        return $json;
    }

    public static function delete($hash)
    {
        $url = "https://api.wistia.com/v1/medias/".$hash.".json?api_password=".self::$password;
        $result = self::curl($url, null, true);
        $json = json_decode($result);

        return $json;
    }

    public static function createProject($name)
    {
        $url = "https://api.wistia.com/v1/projects.json?api_password=".self::$password;
        $data = array(
            "name" => $name
        );
        $result = self::curl($url, $data);
        $json = json_decode($result);

        return $json;
    }

    public static function getProject($hash)
    {
        $url = "https://api.wistia.com/v1/projects/".$hash.".json?api_password=".self::$password;
        $result = self::curl($url);
        $json = json_decode($result);

        return $json;
    }

    public static function listProjects()
    {
        $url = "https://api.wistia.com/v1/projects.json?api_password=".self::$password;
        $result = self::curl($url);
        $json = json_decode($result);

        return $json;
    }

    public static function listMedias($project)
    {
        $url = "https://api.wistia.com/v1/medias.json?api_password=".self::$password;
        $result = self::curl($url);
        $json = json_decode($result);

        return $json;
    }

    public static function moveMedia($mediaHash, $destinationProjectHash)
    {
        //Copy
        $url = "https://api.wistia.com/v1/medias/".$mediaHash."/copy.json?api_password=".self::$password;
        $data = array(
            "project_id" => $destinationProjectHash,
        );
        $result = self::curl($url, $data);
        $json = json_decode($result);
        if ($json->id) {

            //Delete origin
            self::delete($mediaHash);

            //Media has a new Id!
            return $json;
        }
    }

    private static function curl($url, $post = array(), $delete = false)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        if (!empty($post)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        if ($delete) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        }
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
