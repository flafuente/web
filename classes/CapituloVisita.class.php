<?php
/**
 * Modelo CapituloVisita
 *
 * @package Tribo\Modelos
 */
class CapituloVisita extends Model
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
        parent::$dbTable = "capitulos_visitas";
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
     * Devuelve el número total de las Visitas recibidas de un capítulo.
     * @param  int $capituloId
     * @return int
     */
    public static function getTotalVisitasByCapituloId($capituloId = null)
    {
        if ($capituloId) {
            $db = Registry::getDb();
            $query = "SELECT count(DISTINCT `ip`) as `total` FROM `capitulos_visitas` WHERE `capituloId`=:capituloId";
            $params = array(":capituloId" => $capituloId);
            $rows = $db->query($query, $params);
            if (count($rows)) {
                return $rows[0]["total"];
            }
        }
    }

    /**
     * Devuelve el número total de las Visitas recibidas de los capítulos de un programa.
     * @param  int $programaId
     * @return int
     */
    public static function getTotalVisitasByProgramaId($programaId = null)
    {
        if ($programaId) {
            $db = Registry::getDb();
            $query = "SELECT count(DISTINCT `ip`) as `total` FROM `capitulos_visitas` WHERE `capituloId` IN (SELECT `id`FROM `capitulos` WHERE `programaId` = :programaId)";
            $params = array(":programaId" => $programaId);
            $rows = $db->query($query, $params);
            if (count($rows)) {
                return $rows[0]["total"];
            }
        }
    }
}
