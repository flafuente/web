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
     * Visible
     * @var bool
     */
    public $visible;
    /**
     * Order
     * @var int
     */
    public $order;
    /**
     * Nombre
     * @var string
     */
    public $nombre;
    /**
     * Hashtag
     * @var string
     */
    public $hashtag;
    /**
     * Wistia Project Hash
     * @var string
     */
    public $wistiaHash;
    /**
     * Slug
     * @var string
     */
    public $slug;
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

    public function setConfigHashtag()
    {
        if ($this->hashtag) {
            $config = Registry::getConfig();
            $config->set("twitterHashtag", $this->hashtag);
        }
    }

    public function validate()
    {
        //nombre
        if (!$this->nombre) {
            Registry::addMessage("Debes introducir un nombre", "error", "nombre");
        } elseif (Categoria::getBy("nombre", $this->nombre, $this->id)) {
            Registry::addMessage("Ya existe una categoría con este nombre", "error", "nombre");
        }
    }

    /**
     * Validación de creación.
     * @return array Errores
     */
    public function validateInsert()
    {
        $this->validate();

        return Registry::getMessages(true);
    }

    /**
     * Combierte el nombre a slug
     * @return string
     */
    public function slugify()
    {
        $slugify = new Cocur\Slugify\Slugify();
        $this->slug =  $slugify->slugify($this->nombre);
    }

    public function order()
    {
        //leemos las categorías
        $categorias = Categoria::select();
        $pos = 0;
        if (count($categorias)) {
            //Primero
            if ($this->order==-1) {
                $this->order = 1;
                $pos++;
            }
            //Recorremos las categorías
            foreach ($categorias as $categoria) {
                $pos++;
                //Si hemos indicado ir aquí...
                if ($this->order==$pos) {
                    $pos++;
                }
                //Movemos la categoría de posición
                $categoria->order = $pos;
                $categoria->update();
            }
            //Último
            if ($this->order==-2) {
                $pos++;
                $this->order = $pos;
            }
        }
    }

    /**
     * Acciones previas a la creación.
     * @return void
     */
    public function preInsert($data = array())
    {
        $this->dateInsert = date("Y-m-d H:i:s");
        $this->slugify();
        if ($data["order"]) {
            $this->order();
        }
    }

    /**
     * Validación de modificación.
     * @return array Errores
     */
    public function validateUpdate()
    {
        $this->validate();

        return Registry::getMessages(true);
    }

    /**
     * Acciones previas a la modificación.
     * @return void
     */
    public function preUpdate($data = array())
    {
        $this->dateUpdate = date("Y-m-d H:i:s");
        $this->slugify();
        if ($data["order"]) {
            $this->order();
        }
    }

    /**
     * Acciones posteriores a la creación.
     * @return void
     */
    public function postInsert($data = array())
    {
        //Añadimos/quitamos los contactos
        $this->syncContactos($data["contactos"]);
    }

    public function postUpdate($data = array())
    {
        //Añadimos/quitamos los contactos
        $this->syncContactos($data["contactos"]);
    }

    /**
     * Añade y quita las tags al vídeo
     * @param  array $tagsIds Id's de las Tags a añadir
     * @return void
     */
    public function syncContactos($contactosIds = array())
    {
        $actualContactosIds = ContactoCategoria::getFieldBy("contactoId", "categoriaId", $this->id);
        //Quitar
        if (count($actualContactosIds)) {
            foreach ($actualContactosIds as $contactoId) {
                if ($contactoId) {
                    //Si el contacto no ha sido pasado por parámetro...
                    if (!@in_array($contactoId, $contactosIds)) {
                        ContactoCategoria::deleteContacto($this->id, $contactoId);
                    }
                }
            }
        }
        //Añadir
        if (count($contactosIds)) {
            foreach ($contactosIds as $contactoId) {
                if ($contactoId) {
                    //Si el contacto no está actualmente...
                    if (!@in_array($contactoId, $actualContactosIds)) {
                        $contactoCategoria = new ContactoCategoria();
                        $contactoCategoria->categoriaId = $this->id;
                        $contactoCategoria->contactoId = $contactoId;
                        $contactoCategoria->insert();
                    }
                }
            }
        }
    }

    /**
     * Envía un email a todos los contactos asociados.
     * @param  array $data Form data.
     * @return bool
     */
    public function sendEmail($data)
    {
        //Validaciones
        //Nombre
        if (!$data["nombre"]) {
            Registry::addMessage("Debes introducir tu nombre", "error", "nombre");
        }
        //Email
        if (!$data["email"]) {
            Registry::addMessage("Debes introducir tu email", "error", "email");
        }
        //Mensaje
        if (!$data["mensaje"]) {
            Registry::addMessage("Debes introducir un mensaje", "error", "mensaje");
        }

        if (!Registry::getMessages(true)) {
            $contactosIds = ContactoCategoria::getFieldBy("contactoId", "categoriaId", $this->id);
            if (count($contactosIds)) {
                foreach ($contactosIds as $contactoId) {
                    $contacto = new Contacto($contactoId);
                    if ($contacto->id) {
                        //Preparamos el email
                        $mailer = Registry::getMailer();
                        $mailer->addAddress($contacto->email);
                        $mailer->Subject = utf8_decode("Nuevo mensaje de contacto");
                        $mailer->msgHTML(
                            Template::renderEmail(
                                "contactoSecciones",
                                array(
                                    "data" => $data,
                                    "seccion" => $this
                                ), "admin"
                            )
                        );
                        $mailer->send();
                    }
                }
            }

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
        //Visibles
        if ($data["visible"]) {
            $query .= " AND `visible` = :visible";
            $params[":visible"] = 1;
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
                $query .= " ORDER BY `order` ASC";
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
