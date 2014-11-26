<?php
/**
 * Modelo CapituloLike
 *
 * @package Tribo\Modelos
 */
class CapituloLike extends Model
{
    /**
     * Id
     * @var int
     */
    public $id;
    /**
     * Id del capítulo
     * @var int
     */
    public $capituloId;
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
        parent::$dbTable = "capitulos_likes";
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
     * Comprueba si un capítulo está marcado con Like con la IP actual
     * @param  int     $capituloId
     * @return boolean
     */
    public static function isLiked($capituloId = null)
    {
        if ($capituloId) {
            $ip = $_SERVER["REMOTE_ADDR"];
            $db = Registry::getDb();
            $query = "SELECT * FROM `capitulos_likes` WHERE `capituloId` = :capituloId AND `ip` = :ip";
            $params = array(
                ":capituloId" => $capituloId,
                ":ip" => $ip,
            );

            if ($db->query($query, $params)) {
                return true;
            }
        }

        return false;
    }

    public static function unlike($capituloId = null)
    {
        if ($capituloId) {
            $ip = $_SERVER["REMOTE_ADDR"];
            $db = Registry::getDb();
            $query = "DELETE FROM `capitulos_likes` WHERE `capituloId` = :capituloId AND `ip` = :ip";
            $params = array(
                ":capituloId" => $capituloId,
                ":ip" => $ip,
            );

            return $db->query($query, $params);
        }
    }

    /**
     * Devuelve el número total de los likes recibidos de un capítulo.
     * @param  int $capituloId
     * @return int
     */
    public static function getTotalLikesByCapituloId($capituloId = null)
    {
        if ($capituloId) {
            $db = Registry::getDb();
            $query = "SELECT count(DISTINCT `ip`) as `total` FROM `capitulos_likes` WHERE `capituloId`=:capituloId";
            $params = array(":capituloId" => $capituloId);
            $rows = $db->query($query, $params);
            if (count($rows)) {
                return $rows[0]["total"];
            }
        }
    }

    /**
     * Devuelve el número total de los likes recibidas de los capítulos de un programa.
     * @param  int $programaId
     * @return int
     */
    public static function getTotalLikesByProgramaId($programaId = null)
    {
        if ($programaId) {
            $db = Registry::getDb();
            $query = "SELECT count(DISTINCT `ip`) as `total` FROM `capitulos_likes` WHERE `capituloId` IN (SELECT `id`FROM `capitulos` WHERE `programaId` = :programaId)";
            $params = array(":programaId" => $programaId);
            $rows = $db->query($query, $params);
            if (count($rows)) {
                return $rows[0]["total"];
            }
        }
    }
}
