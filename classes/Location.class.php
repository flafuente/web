<?php
/**
 * Modelo Location
 *
 * @package Tribo\Modelos
 */
class Location extends Model
{
    /**
     * Id
     * @var int
     */
    public $id;
    /**
     * Langauge Id
     * @var int
     */
    public $langId;
    /**
     * Item name
     * @var string
     */
    public $item;
    /**
     * Item Id
     * @var int
     */
    public $itemId;
    /**
     * Field
     * @var string
     */
    public $field;
    /**
     * Traducción
     * @var string
     */
    public $location;
    /**
     * Fecha de creación
     * @var string
     */
    public $dateInsert;
    /**
     * Fecha de modificación
     * @var string
     */
    public $dateUpdate;

    public static $languages = array(
        1 => "en_GB",
    );

    /**
     * Variables reservadas (no están en la base de datos)
     * @var array
     */
    public static $reservedVarsChild = array("languages");

    /**
     * Init.
     * @return void
     */
    public function init()
    {
        //Tabla usada en la DB
        parent::$dbTable = "locations";
        //Variables reservadas
        parent::$reservedVarsChild = self::$reservedVarsChild;
    }

    public static function translate($object, $field, $lang = null)
    {

        //Item Id
        if (is_object($object)) {
            $itemId = $object->id;
            $item = get_class($object);
        }
        //Lang Id
        if (!$lang) {
            session_start();
            $lang = $_SESSION['lang'];
        }
        $langId = $lang;
        if (!is_numeric($lang)) {
            $langId = @array_search($lang, Location::$languages);
        }

        if ($langId && isset(Location::$languages[$langId])) {
            $location = self::getLocation($item, $itemId, $field, $langId);
            if ($location->id) {
                return $location->location;
            }
        }

        return $object->$field;

    }

    private static function getLocation($item, $itemId, $field, $langId)
    {
        $db = Registry::getDb();
        //Query
        $query = "SELECT * FROM `locations` WHERE `item` = :item AND `itemId` = :itemid AND `field` = :field AND `langId` = :langId";
        $params = array(
            ":item" => strtolower($item),
            ":itemid" => $itemId,
            ":field" => strtolower($field),
            ":langId" => $langId,
        );
        $rows = $db->query($query, $params);
        if (count($rows)) {
            return new LocatioN($rows[0]);
        }
    }

    /**
     * Acciones previas a la creación.
     * @return void
     */
    public function preInsert()
    {
        $this->dateInsert = date("Y-m-d H:i:s");
    }

    /**
     * Acciones previas a la modificación.
     * @return void
     */
    public function preUpdate()
    {
        $this->dateUpdate = date("Y-m-d H:i:s");
    }

    /**
     * Obtiene registros de la base de datos.
     * @param  array   $data       Condicionales / ordenación
     * @param  integer $limit      Límite de resultados (Paginación)
     * @param  integer $limitStart Inicio de la limitación (Paginación)
     * @param  int     $total      Total de filas encontradas (Paginación)
     * @return array   Modelos de la clase actual
     */
    public function select($data = array(), $limit = 0, $limitStart = 0, &$total = null)
    {
        $db = Registry::getDb();
        //Query
        $query = "SELECT * FROM `locations` ";
        $params = array();
        //Where
        $where .= " WHERE 1=1 ";
        $query .= $where;
        //Total
        $total = count($db->Query($query, $params));
        if ($total) {
            //Order
            if ($data['order'] && $data['orderDir']) {
                //Secure Field
                $orders = array("ASC", "DESC");
                if (@in_array($data['order'], array_keys(get_class_vars(__CLASS__))) && in_array($data['orderDir'], $orders)) {
                    $query .= " ORDER BY `".$data['order']."` ".$data['orderDir'];
                }
            }
            //Limit
            if ($limit) {
                $query .= " LIMIT ".(int) $limitStart.", ".(int) $limit;
            }
            $rows = $db->Query($query, $params);
            if (count($rows)) {
                foreach ($rows as $row) {
                    $results[] = new Location($row);
                }

                return $results;
            }
        }
    }
}
