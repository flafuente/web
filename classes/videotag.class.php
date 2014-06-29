<?php
/**
 * Modelo VídeoTag
 *
 * @package Tribo\Modelos
 */
class VideoTag extends Model
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
     * Id del Tag
     * @var int
     */
    public $tagId;
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
        parent::$dbTable = "videos_tags";
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

    public static function deleteTag($videoId, $tagId)
    {
        $db = Registry::getDb();
        $query = "DELETE FROM `videos_tags` WHERE `videoId`=:videoId AND `tagId`=:tagId";
        $params = array(
            ":videoId" => $videoId,
            ":tagId" => $tagId
        );
        if ($db->query($query, $params)) {
            return true;
        }
    }

    /**
     * Devuelve los Tags asociados a un vídeo
     * @param  integer $videoId Id del vídeo
     * @return array Objetos VideoTag
     */
    public static function getVideosTagsByVideoId($videoId=0)
    {
        $db = Registry::getDb();
        $params = array();
        $query = "SELECT * FROM `videos_tags` WHERE `videoId`=:videoId";
        $params[":videoId"] = $videoId;
        $rows = $db->query($query, $params);
        if (count($rows)) {
            foreach ($rows as $row) {
                $results[] = new VideoTag($row);
            }

            return $results;
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
        $query = "SELECT * FROM `videos_tags` WHERE 1=1 ";
        //Total
        $total = count($db->Query($query));
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
            $rows = $db->Query($query);
            if (count($rows)) {
                foreach ($rows as $row) {
                    $results[] = new VideoTag($row);
                }

                return $results;
            }
        }
    }
}
