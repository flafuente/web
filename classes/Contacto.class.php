<?php
/**
 * Modelo Contacto
 *
 * @package Tribo\Modelos
 */
class Contacto extends Model
{
    /**
     * Id
     * @var int
     */
    public $id;
    /**
     * Id del usuario creador
     * @var int
     */
    public $userId;
    /**
     * Id de la sección
     * @var int
     */
    public $seccionId;
    /**
     * Email
     * @var string
     */
    public $email;
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
        parent::$dbTable = "contactos";
    }

    /**
     * Validación para creación/edición del capítulo.
     * @return array Array de errores
     */
    private function validate()
    {
        //Sección
        if (!$this->seccionId) {
            Registry::addMessage("Debes seleccionar una seccion", "error", "seccionId");
        }
        //Email
        if (!$this->email) {
            Registry::addMessage("Debes introducir un email", "error", "email");
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
        $user = Registry::getUser();
        $this->userId = $user->id;
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
    public function select($data=array(), $limit=0, $limitStart=0, &$total=null)
    {
        $db = Registry::getDb();
        //Query
        $query = "SELECT * FROM `contactos` WHERE 1=1 ";
        $params = array();
        //Where
        //Búsqueda
        if ($data["search"]) {
            $query .= " AND `email` LIKE :email";
            $params[":email"] = "%".$data["search"]."%";
        }
        //SeccionId
        if ($data["seccionId"]) {
            $query .= " AND `seccionId`=:seccionId";
            $params[":seccionId"] = $data["seccionId"];
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
                    $results[] = new Contacto($row);
                }

                return $results;
            }
        }
    }
}
