<?php
/**
 * Modelo ContactoCategoría
 *
 * @package Tribo\Modelos
 */
class ContactoCategoria extends Model
{
    /**
     * Id
     * @var int
     */
    public $id;
    /**
     * Id de la categoría
     * @var int
     */
    public $categoriaId;
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
        parent::$dbTable = "contactos_categorias";
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

    public static function deleteContacto($categoriaId, $contactoId)
    {
        $db = Registry::getDb();
        $query = "DELETE FROM `contactos_categorias` WHERE `categoriaId`=:categoriaId AND `contactoId`=:contactoId";
        $params = array(
            ":categoriaId" => $categoriaId,
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
        $query = "SELECT * FROM `contactos_categorias` WHERE 1=1 ";
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
                    $results[] = new ContactoCategoria($row);
                }

                return $results;
            }
        }
    }
}
