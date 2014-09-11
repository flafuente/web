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
     * Variables reservadas (no están en la base de datos)
     * @var array
     */
    public static $reservedVarsChild = array("path");

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

    public function getMenuImage()
    {
        return Url::template("img/home/".$this->menuImage);
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
}
