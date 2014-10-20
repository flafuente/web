<?php
/**
 * Modelo Sección
 *
 * @package Tribo\Modelos
 */
class Seccion extends Model
{
    /**
     * Id de la sección
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
     * Imágen para el menú
     * @var string
     */
    public $menuImage;
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
    public $path = "/files/images/secciones/";

    /**
     * Textos traducibles
     * @var array
     */
    public $locations = array("nombre");

    /**
     * Variables reservadas (no están en la base de datos)
     * @var array
     */
    public static $reservedVarsChild = array("path", "locations");

    /**
     * Init.
     * @return void
     */
    public function init()
    {
        //Tabla usada en la DB
        parent::$dbTable = "secciones";
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

    /**
     * Devuelve la URL del Thumbnail.
     * @return string
     */
    public function getThumbnailUrl()
    {
        return Url::site($this->path.$this->thumbnail);
    }

    /**
     * Devuelve la ruta del Thumbnail.
     * @return string
     */
    public function getThumbnailPath()
    {
        $config = Registry::getConfig();

        return $config->get("path").$this->path.$this->thumbnail;
    }

    public function getMenuImage()
    {
        return Url::template("img/home/".$this->menuImage, "tribo");
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
        if (isset($_FILES["thumbnail"]) && $_FILES["thumbnail"]["size"] > 0) {
            try {
                //Eliminamos la antigua
                $this->deleteThumbnail();
                //Subimos la nueva
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
        //leemos las secciones
        $secciones = Seccion::select();
        $pos = 0;
        if (count($secciones)) {
            //Primero
            if ($this->order==-1) {
                $this->order = 1;
                $pos++;
            }
            //Recorremos las secciones
            foreach ($secciones as $seccion) {
                $pos++;
                //Si hemos indicado ir aquí...
                if ($this->order==$pos) {
                    $pos++;
                }
                //Movemos la sección de posición
                $seccion->order = $pos;
                $seccion->update();
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
        if (!$this->slug) {
            $this->slugify();
        }
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
        if (!$this->slug) {
            $this->slugify();
        }
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
        $actualContactosIds = ContactoSeccion::getFieldBy("contactoId", "seccionId", $this->id);
        //Quitar
        if (count($actualContactosIds)) {
            foreach ($actualContactosIds as $contactoId) {
                if ($contactoId) {
                    //Si el contacto no ha sido pasado por parámetro...
                    if (!@in_array($contactoId, $contactosIds)) {
                        ContactoSeccion::deleteContacto($this->id, $contactoId);
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
                        $ContactoSeccion = new ContactoSeccion();
                        $ContactoSeccion->seccionId = $this->id;
                        $ContactoSeccion->contactoId = $contactoId;
                        $ContactoSeccion->insert();
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
        if (!Contacto::validateSend($data)) {
            $contactosIds = ContactoSeccion::getFieldBy("contactoId", "seccionId", $this->id);
            if (count($contactosIds)) {
                foreach ($contactosIds as $contactoId) {
                    $contacto = new Contacto($contactoId);
                    $contacto->sendEmail($data);
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
        $query = "SELECT * FROM `secciones` WHERE 1=1 ";
        $params = array();
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
                    $results[] = new Seccion($row);
                }

                return $results;
            }
        }
    }

    /**
     * Acciones posteriores a la eliminación.
     * @return void
     */
    public function postDelete()
    {
        $this->deleteThumbnail();
    }

    private function deleteThumbnail()
    {
        if ($this->thumbnail) {
            return @unlink($this->getThumbnailPath());
        }
        $this->thumbnail = "";
    }
}
