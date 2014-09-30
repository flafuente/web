<?php
/**
 * Modelo Comunidad
 *
 * @package Tribo\Modelos
 */
class Comunidad extends Model
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
     * Código
     * @var string
     */
    public $codigo;

    /**
     * Init.
     * @return void
     */
    public function init()
    {
        //Tabla usada en la DB
        parent::$dbTable = "comunidades";
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
        $query = "SELECT * FROM `comunidades`";
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
            } else {
                $query .= " ORDER BY nombre ASC";
            }
            //Limit
            if ($limit) {
                $query .= " LIMIT ".(int) $limitStart.", ".(int) $limit;
            }
            $rows = $db->Query($query);
            if (count($rows)) {
                foreach ($rows as $row) {
                    $results[] = new Comunidad($row);
                }

                return $results;
            }
        }
    }
}
