<?php
/**
 * Modelo SecciónContacto
 *
 * @package Tribo\Modelos
 */
class SeccionContacto extends Model
{
    /**
     * Id
     * @var int
     */
    public $id;
    /**
     * Id de la sección
     * @var int
     */
    public $seccionId;
    /**
     * Id del contacto
     * @var int
     */
    public $contactoId;
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
        parent::$dbTable = "secciones_contactos";
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

    public static function deleteContacto($seccionId, $contactoId)
    {
        $db = Registry::getDb();
        $query = "DELETE FROM `secciones_contactos` WHERE `seccionId`=:seccionId AND `contactoId`=:contactoId";
        $params = array(
            ":seccionId" => $seccionId,
            ":contactoId" => $contactoId
        );
        if ($db->query($query, $params)) {
            return true;
        }
    }

    /**
     * Obtiene registros de la base de datos.
     * @param  array   $data       Condicionales / ordenación
     * @param  integer $limit      Límite de resultados (Paginación)
     * @param  integer $limitStart Inicio de la limitación (Paginación)
     * @param  int     $total      Total de filas encontradas (Paginación)
     * @return array   Modelos de la clase actual
     */
    public function select($data=array(), $limit=0, $limitStart=0, &$total=null)
    {
        $db = Registry::getDb();
        //Query
        $query = "SELECT * FROM `secciones_contactos` WHERE 1=1 ";
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
                    $results[] = new SeccionContacto($row);
                }

                return $results;
            }
        }
    }
}
