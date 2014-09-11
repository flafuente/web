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
     * Id del usuario
     * @var int
     */
    public $userId;
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
        $this->dateInsert = date("Y-m-d H:i:s");
    }

    public static function unlike($capituloId = null)
    {
        if ($capituloId) {
            $user = Registry::getUser();

            $db = Registry::getDb();
            $query = "DELETE FROM `capitulos_likes` WHERE `capituloId` = :capituloId AND `usuarioId` = :usuarioId";
            $params = array(
                ":capituloId" => $capituloId,
                ":usuarioId" => $user->id,
            );

            return $db->query($query, $params);
        }
    }

    /**
     * Devuelve el número total de las Likes recibidos de un capítulo.
     * @param  integer $capituloId Id del capítulo
     * @return int
     */
    public function getTotalLikesByCapituloId($capituloId = null)
    {
        if ($capituloId) {
            $db = Registry::getDb();
            $params = array();
            $query = "SELECT count(DISTINCT `ip`) as `total` FROM `capitulos_likes` WHERE `capituloId`=:capituloId";
            $params[":capituloId"] = $capituloId;
            $rows = $db->query($query, $params);
            if (count($rows)) {
                return $rows[0]["total"];
            }
        }
    }
}
