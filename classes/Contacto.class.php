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
     * Visible
     * @var int
     */
    public $visible;
    /**
     * Id del usuario creador
     * @var int
     */
    public $userId;
    /**
     * Nombre
     * @var string
     */
    public $nombre;
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
        //Nombre
        if (!$this->nombre) {
            Registry::addMessage("Debes introducir un nombre", "error", "nombre");
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

    public function validateSend($data)
    {
        //Nombre
        if (!$data["nombre"]) {
            Registry::addMessage("Debes introducir tu nombre", "error", "nombre");
        }
        //Email
        if (!$data["email"]) {
            Registry::addMessage("Debes introducir tu email", "error", "email");
        } elseif (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
            Registry::addMessage("Email incorrecto", "error", "email");
        }
        //Mensaje
        if (!$data["mensaje"]) {
            Registry::addMessage("Debes introducir un mensaje", "error", "mensaje");
        }

        return Registry::getMessages(true);
    }

    /**
     * Envía un email al contacto.
     * @param  array $data Form data.
     * @return bool
     */
    public function sendEmail($data)
    {
        //Preparamos el email
        $mailer = Registry::getMailer();
        $mailer->addAddress($this->email);
        $mailer->Subject = utf8_decode("Nuevo mensaje de contacto");
        $mailer->msgHTML(
            Template::renderEmail(
                "contacto",
                array(
                    "data" => $data
                ), "admin"
            )
        );
        $mailer->send();

        return true;
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
        //Visible
        if ($data["visible"]) {
            $query .= " AND `visible` = 1 ";
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
