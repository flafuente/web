<?php
/**
 * Modelo Slide (Slideshow)
 *
 * @package Tribo\Modelos
 */
class Slide extends Model
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
     * Imágen (filename)
     * @var string
     */
    public $imagen;
    /**
     * Url
     * @var string
     */
    public $url;
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
    public $path = "/files/images/slideshow/";

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
        parent::$dbTable = "slides";
        //Variables reservadas
        parent::$reservedVarsChild = self::$reservedVarsChild;
    }

    /**
     * Devuelve la URL de la imágen.
     * @return string
     */
    public function getImagenUrl()
    {
        return Url::site($this->path.$this->imagen);
    }

    /**
     * Devuelve el path de la imágen.
     * @return string
     */
    public function getImagenPath()
    {
        $config = Registry::getConfig();
        if ($this->imagen) {
            return $config->get("path").$this->path.$this->imagen;
        }
    }

    public function getUrl()
    {
        if (strstr($this->url, "http")) {
            return $this->url;
        } else {
            return Url::site($this->url);
        }
    }

    public function validate()
    {
        $config = Registry::getConfig();
        //nombre
        if (!$this->nombre) {
            Registry::addMessage("Debes introducir un nombre", "error", "nombre");
        }
        //url
        if (!$this->url) {
            Registry::addMessage("Debes introducir una url", "error", "url");
        }
        //Image Upload
        if (isset($_FILES["imagenFile"]) && $_FILES["imagenFile"]["size"] > 0) {
            try {
                //Eliminamos la anterior
                $this->deleteImagen();
                //Subimos la nueva
                $bulletProof = new BulletProof;
                $this->imagen = $bulletProof
                    ->uploadDir($config->get("path").$this->path)
                    ->shrink(array("height"=>310, "width"=>960))
                    ->upload($_FILES['imagenFile']);
            } catch (ImageUploaderException $e) {
                Registry::addMessage("Error al subir la imagen: ".$e->getMessage(), "error");
            }
        } elseif (!$this->imagen) {
            Registry::addMessage("Debes subir una imagen", "error");
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

    public function order()
    {
        //leemos las slides
        $slides = Slide::select();
        $pos = 0;
        if (count($slides)) {
            //Primero
            if ($this->order == -1) {
                $this->order = 1;
                $pos++;
            }
            //Recorremos las slides
            foreach ($slides as $slide) {
                $pos++;
                //Si hemos indicado ir aquí...
                if ($this->order == $pos) {
                    $pos++;
                }
                //Movemos la slide de posición
                $slide->order = $pos;
                $slide->update();
            }
            //Último
            if ($this->order == -2) {
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
    public function select($data = array(), $limit = 0, $limitStart = 0, &$total = null)
    {
        $db = Registry::getDb();
        //Query
        $query = "SELECT * FROM `slides` WHERE 1=1 ";
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
                    $results[] = new Slide($row);
                }

                return $results;
            }
        }
    }

    public function postDelete()
    {
        $this->deleteImagen();
    }

    private function deleteImagen()
    {
        if ($this->imagen) {
            return @unlink($this->getImagenPath());
        }
        $this->imagen = "";
    }
}
