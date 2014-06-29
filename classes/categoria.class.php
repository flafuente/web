<?php
/**
 * Modelo Categoría
 *
 * @package Tribo\Modelos
 */
class Categoria extends Model
{
    /**
     * Id de la categoría
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
        parent::$dbTable = "categorias";
        //Variables reservadas
        parent::$reservedVarsChild = self::$reservedVarsChild;
    }

    /**
     * Validación de creación.
     * @return array Errores
     */
    public function validateInsert()
    {
        //nombre
        if (!$this->nombre) {
            Registry::addMessage("Debes introducir un nombre", "error", "nombre");
        } elseif ($this->getCategoriaByNombre($this->nombre)) {
            Registry::addMessage("Ya existe una categoría con este nombre", "error", "nombre");
        }

        return Registry::getMessages(true);
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
        //nombre
        if (!$this->nombre) {
            Registry::addMessage("Debes introducir un nombre", "error", "nombre");
        } elseif ($this->getCategoriaByNombre($this->nombre)) {
            Registry::addMessage("Ya existe una categoría con este nombre", "error", "nombre");
        }

        return Registry::getMessages(true);
    }

    /**
     * Busca una categoría por su nombre.
     * @param  string  $nombre   Nombre
     * @param  integer $ignoreId Id a ignorar
     * @return object
     */
    public function getCategoriaByNombre($nombre, $ignoreId=0)
    {
        $db = Registry::getDb();
        $params = array();
        $query = "SELECT * FROM `categorias` WHERE nombre = :nombre";
        $params[":nombre"] = $nombre;
        //Ignore Id
        if ($ignoreId) {
            $params[":ignoreId"] = $ignoreId;
            $query .= " AND `id` != :ignoreId";
        }
        $rows = $db->query($query, $params);
        if (count($rows)) {
            return new Categoria($rows[0]);
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
        $query = "SELECT * FROM `categorias` WHERE 1=1 ";
        $params = array();
        //Where
        if (isset($data["categoriasIds"])) {
            //INSECURE!
            $query .= " AND `id` IN (".implode(",", $data["categoriasIds"]).") ";
        }
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
            } else {
                $query .= " ORDER BY `nombre` ASC";
            }
            //Limit
            if ($limit) {
                $query .= " LIMIT ".(int) $limitStart.", ".(int) $limit;
            }
            $rows = $db->Query($query, $params);
            if (count($rows)) {
                foreach ($rows as $row) {
                    $results[] = new Categoria($row);
                }

                return $results;
            }
        }
    }
}
