<?php
/**
 * Modelo Tag
 *
 * @package Tribo\Modelos
 */
class Tag extends Model
{
    /**
     * Id
     * @var int
     */
    public $id;
    /**
     * Nombre
     * @var string
     */
    public $nombre;
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

    /**
     * Init.
     * @return void
     */
    public function init()
    {
        //Tabla usada en la DB
        parent::$dbTable = "tags";
        //Variables reservadas
        parent::$reservedVarsChild = self::$reservedVarsChild;
    }

    /**
     * Validación para creación/edición del capítulo.
     * @return array Array de errores
     */
    private function validate()
    {
        //nombre
        if (!$this->nombre) {
            Registry::addMessage("Debes introducir un nombre", "error", "nombre");
        } elseif ($this->getTagByNombre($this->nombre, $this->id)) {
            Registry::addMessage("Ya existe un tag con este nombre", "error", "nombre");
        }

        return Registry::getMessages(true);
    }

    /**
     * Validación de creación.
     * @return array Errores
     */
    public function validateInsert()
    {
        return $this->validate();
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
     * Validación de modificación.
     * @return array Errores
     */
    public function validateUpdate()
    {
        return $this->validate();
    }

    public static function getTagsByVideoId($videoId=0)
    {
        $db = Registry::getDb();
        $params = array();
        $query = "SELECT * FROM `tags` WHERE `id` IN (SELECT `tagId` FROM `videos_tags` WHERE `videoId`=:videoId)";
        $params[":videoId"] = $videoId;
        $rows = $db->query($query, $params);
        if (count($rows)) {
            foreach ($rows as $row) {
                $results[] = new Tag($row);
            }

            return $results;
        }
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
     * Busca los Ids de los Tags que contiene un vídeo.
     * @param  integer $videoId Id del vídeo
     * @return array Ids de los tags
     */
    public static function getTagsIdsByVideoId($videoId=0)
    {
        $db = Registry::getDb();
        $params = array();
        $query = "SELECT `id` FROM `tags` WHERE `id` IN (SELECT `tagId` FROM `videos_tags` WHERE `videoId`=:videoId)";
        $params[":videoId"] = $videoId;
        $rows = $db->query($query, $params);
        if (count($rows)) {
            foreach ($rows as $row) {
                $results[] = $row["tagId"];
            }

            return $results;
        }
    }

    /**
     * Busca un Tag por su nombre.
     * @param  string  $nombre   Nombre
     * @param  integer $ignoreId Id a ignorar
     * @return object
     */
    public function getTagByNombre($nombre, $ignoreId=0)
    {
        $db = Registry::getDb();
        $params = array();
        $query = "SELECT * FROM `tags` WHERE nombre = :nombre";
        $params[":nombre"] = $nombre;
        //Ignore Id
        if ($ignoreId) {
            $params[":ignoreId"] = $ignoreId;
            $query .= " AND `id` != :ignoreId";
        }
        $rows = $db->query($query, $params);
        if (count($rows)) {
            return new Tag($rows[0]);
        }
    }

    /**
     * Obtiene registros de la base de datos.
     * @param  array    $data           Condicionales / ordenación
     * @param  integer  $limit          Límite de resultados (Paginación)
     * @param  integer  $limitStart     Inicio de la limitación (Paginación)
     * @param  int      $total          Total de filas encontradas (Paginación)
     * @return array                    Modelos de la clase actual
     */
    public function select($data=array(), $limit=0, $limitStart=0, &$total=null)
    {
        $db = Registry::getDb();
        //Query
        $query = "SELECT * FROM `tags` WHERE 1=1 ";
        $params = array();
        //Where
        //Búsqueda
        if ($data["search"]) {
            $query .= " AND `nombre` LIKE :nombre";
            $params[":nombre"] = "%".$data["search"]."%";
        }
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
                    $results[] = new Tag($row);
                }

                return $results;
            }
        }
    }
}
