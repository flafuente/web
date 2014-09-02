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
     * Tipo
     * @var int
     */
    public $tipoId;
    /**
     * Destacada
     * @var bool
     */
    public $destacada;
    /**
     * Secciones
     * @var string
     */
    public $secciones;
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
     * Color
     * @var string
     */
    public $color;
    /**
     * Thumbnail (filename)
     * @var string
     */
    public $thumbnail;
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
     * Ruta de las imágenes
     * @var string
     */
    public $path = "/files/images/categorias/";

    public $seccionesTipos = array(
        1 => "Programas",
        2 => "Notícias",
    );

    public $tipos = array(
        1 => "Normal",
        2 => "Periodismo",
    );

    /**
     * Variables reservadas (no están en la base de datos)
     * @var array
     */
    public static $reservedVarsChild = array("path", "seccionesTipos", "tipos");

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
     * @return array Ids de las secciones a las que pertenece
     */
    public function getSecciones()
    {
        if ($this->secciones) {
            return json_decode($this->secciones);
        }
    }

    /**
     * Devuelve la URL del Thumbnail.
     * @return string
     */
    public function getThumbnailUrl()
    {
        return Url::site($this->path.$this->thumbnail);
    }

    public function validate()
    {
        $config = Registry::getConfig();
        //nombre
        if (!$this->nombre) {
            Registry::addMessage("Debes introducir un nombre", "error", "nombre");
        } elseif (Categoria::getBy("nombre", $this->nombre, $this->id)) {
            Registry::addMessage("Ya existe una categoría con este nombre", "error", "nombre");
        }
        //Thumbnail Upload
        if (isset($_FILES["thumbnail"])) {
            try {
                $bulletProof = new BulletProof;
                $this->thumbnail = $bulletProof
                    ->uploadDir($config->get("path").$this->path)
                    ->shrink(array("height"=>144, "width"=>240))
                    ->upload($_FILES['thumbnail']);
            } catch (ImageUploaderException $e) {
                Registry::addMessage("Error al subir la imagen: ".$e->getMessage(), "error");
            }
        } else {
            $this->thumbnail = null;
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
        //Secciones
        if (isset($data["secciones"])) {
            $this->secciones = json_encode($data["secciones"]);;
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
        //Secciones
        if (isset($data["secciones"])) {
            $this->secciones = json_encode($data["secciones"]);;
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
        if (isset($data["seccionId"])) {
            //INSECURE!
            $query .= " AND `secciones` LIKE :sectid ";
            $params[":sectid"] = '%["'.$data["seccionId"].'"]%';
        }
        //Búsqueda
        if ($data["search"]) {
            $query .= " AND `nombre` LIKE :nombre";
            $params[":nombre"] = "%".$data["search"]."%";
        }
        //Destacadas
        if ($data["destacada"]) {
            $query .= " AND `destacada` = :destacada";
            $params[":destacada"] = 1;
        }
        //TipoId
        if ($data["tipoId"]) {
            $query .= " AND `tipoId` = :tipoId";
            $params[":tipoId"] = $data["tipoId"];
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
