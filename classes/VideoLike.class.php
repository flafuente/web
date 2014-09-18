<?php
/**
 * Modelo VideoLike
 *
 * @package Tribo\Modelos
 */
class VideoLike extends Model
{
    /**
     * Id
     * @var int
     */
    public $id;
    /**
     * Id del vídeo
     * @var int
     */
    public $videoId;
    /**
     * Ip del visitante
     * @var int
     */
    public $ip;
    /**
     * Fecha de creación
     * @var string
     */
    public $dateInsert;

    /**
     * Init.
     * @return void
     */
    public function init()
    {
        //Tabla usada en la DB
        parent::$dbTable = "videos_likes";
        //Variables reservadas
        parent::$reservedVarsChild = self::$reservedVarsChild;
    }

    /**
     * Acciones previas a la creación.
     * @return void
     */
    public function preInsert()
    {
        $this->ip = $_SERVER["HTTP_CF_IPCOUNTRY"];
        $this->dateInsert = date("Y-m-d H:i:s");
    }

    /**
     * Comprueba si un vídeo está marcado con Like con la IP actual
     * @param  int     $videoId
     * @return boolean
     */
    public static function isLiked($videoId = null)
    {
        if ($videoId) {
            $ip = $_SERVER["HTTP_CF_IPCOUNTRY"];
            $db = Registry::getDb();
            $query = "SELECT * FROM `videos_likes` WHERE `videoId` = :videoId AND `ip` = :ip";
            $params = array(
                ":videoId" => $videoId,
                ":ip" => $ip,
            );

            if ($db->query($query, $params)) {
                return true;
            }
        }

        return false;
    }

    public static function unlike($videoId = null)
    {
        if ($videoId) {
            $ip = $_SERVER["HTTP_CF_IPCOUNTRY"];
            $db = Registry::getDb();
            $query = "DELETE FROM `videos_likes` WHERE `videoId` = :videoId AND `ip` = :ip";
            $params = array(
                ":videoId" => $videoId,
                ":ip" => $ip,
            );

            return $db->query($query, $params);
        }
    }

    /**
     * Devuelve el número total de las Likes recibidos de un vídeo.
     * @param  integer $videoId Id del capítulo
     * @return int
     */
    public static function getTotalLikesByVideoId($videoId = null)
    {
        if ($videoId) {
            $db = Registry::getDb();
            $query = "SELECT count(DISTINCT `ip`) as `total` FROM `videos_likes` WHERE `videoId`=:videoId";
            $params = array(":videoId" => $videoId);
            $rows = $db->query($query, $params);
            if (count($rows)) {
                return $rows[0]["total"];
            }
        }
    }
}
