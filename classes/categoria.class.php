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
        parent::$dbTable = "categorias";
        //Variables reservadas
        parent::$reservedVarsChild = self::$reservedVarsChild;
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
        } elseif ($this->getCategoriaByNombre($this->nombre, $this->id)) {
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
     * Busca una categoría por su slug.
     * @param  string $slug slug
     * @return object
     */
    public function getCategoriaBySlug($slug)
    {
        $db = Registry::getDb();
        $params = array();
        $query = "SELECT * FROM `categorias` WHERE slug = :slug";
        $params[":slug"] = $slug;
        $rows = $db->query($query, $params);
        if (count($rows)) {
            return new Categoria($rows[0]);
        }
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
    public function preUpdate($data = array())
    {
        $this->dateUpdate = date("Y-m-d H:i:s");
        $this->slugify();
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
