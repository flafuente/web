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
     * Textos traducibles
     * @var array
     */
    public $locations = array("nombre");

    /**
     * Variables reservadas (no están en la base de datos)
     * @var array
     */
    public static $reservedVarsChild = array("locations");

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

    /**
     * Devuelve la categoría más usada en los vídeos del usuario.
     * @param  integer $userId
     * @return object
     */
    public function getEspecialidadByUserId($userId)
    {
        $db = Registry::getDb();
        $query = "SELECT `categoriaId`, COUNT(id) as `total` FROM `videos` WHERE `userId` = :userId GROUP BY `categoriaId` ORDER BY `total` LIMIT 1";
        $params = array(
            ":userId" => $userId,
        );
        $rows = $db->query($query, $params);
        if (count($rows)) {
            return new Categoria($rows[0]["categoriaId"]);
        }
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
