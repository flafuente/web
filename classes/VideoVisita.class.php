<?php
/**
 * Modelo VideoVisita
 *
 * @package Tribo\Modelos
 */
class VideoVisita extends Model
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
     * @var string
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
        parent::$dbTable = "videos_visitas";
        //Variables reservadas
        parent::$reservedVarsChild = self::$reservedVarsChild;
    }

    /**
     * Acciones previas a la creación.
     * @return void
     */
    public function preInsert()
    {
        $this->ip = $_SERVER["REMOTE_ADDR"];
        $this->dateInsert = date("Y-m-d H:i:s");
    }

    /**
     * Devuelve el número total de las Visitas recibidas de un Vídeo.
     * @param  integer $videoId Id del vídeo
     * @return int
     */
    public static function getTotalVisitasByVideoId($videoId=0)
    {
        if ($videoId) {
            $db = Registry::getDb();
            $query = "SELECT count(DISTINCT `ip`) as `total` FROM `videos_visitas` WHERE `videoId`=:videoId";
            $params = array(":videoId" => $videoId);
            $rows = $db->query($query, $params);
            if (count($rows)) {
                return $rows[0]["total"];
            }
        }
    }
}
