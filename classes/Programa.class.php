<?php
/**
 * Modelo Programa
 *
 * @package Tribo\Modelos
 */
class Programa extends Model
{
    /**
     * Id
     * @var int
     */
    public $id;
    /**
     * Order
     * @var int
     */
    public $order;
    /**
     * Id de la sección
     * @var int
     */
    public $seccionId;
    /**
     * Id del usuario creador
     * @var int
     */
    public $userId;
    /**
     * Id del estado del capítulo
     * @var int
     */
    public $estadoId;
    /**
     * Destacado
     * @var bool
     */
    public $destacado;
    /**
     * Banner (filename)
     * @var string
     */
    public $banner;
    /**
     * Thumbnail (filename)
     * @var string
     */
    public $thumbnail;
    /**
     * Color
     * @var string
     */
    public $color;
    /**
     * Slug
     * @var string
     */
    public $slug;
    /**
     * Título
     * @var string
     */
    public $titulo;
    /**
     * Subtítulo
     * @var string
     */
    public $subtitulo;
    /**
     * Descipción
     * @var string
     */
    public $descripcion;
    /**
     * Nº total de visitas recibidas (en sus capítulos)
     * @var int
     */
    public $visitas;
    /**
     * Nº total de likes recibidos (en sus capítulos)
     * @var int
     */
    public $likes;
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
     * Clases CSS de los estados
     * @var array
     */
    public $estadosCss = array(
        0 => "default",
        1 => "success",
        2 => "danger",
    );
    /**
     * Tipos de estado
     * @var array
     */
    public $estados = array(
        0 => "No publicado",
        1 => "Publicado",
    );
    /**
     * Ruta de las imágenes
     * @var string
     */
    public $path = "/files/images/programas/";

    /**
     * Variables reservadas (no están en la base de datos)
     * @var array
     */
    public static $reservedVarsChild = array("estados", "estadosCss", "path");

    /**
     * Init.
     * @return void
     */
    public function init()
    {
        //Tabla usada en la DB
        parent::$dbTable = "programas";
        //Variables reservadas
        parent::$reservedVarsChild = self::$reservedVarsChild;
    }

    /**
     * Devuelve la ruta del Banner.
     * @return string
     */
    public function getBannerPath()
    {
        $config = Registry::getConfig();

        return Url::site($config->get("path").$this->path.$this->banner);
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

    public function updateVisitas()
    {
        $this->visitas = CapituloVisita::getTotalVisitasByProgramaId($this->id);

        return $this->update();
    }

    public function updateLikes()
    {
        $this->likes = CapituloLike::getTotalLikesByProgramaId($this->id);

        return $this->update();
    }

    /**
     * Devuelve la URL del Banner.
     * @return string
     */
    public function getBannerUrl()
    {
        $config = Registry::getConfig();

        return $config->get("path").$this->path.$this->banner;
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
     * Devuelve el estado actual del capítulo.
     * @return string Estado
     */
    public function getEstadoString()
    {
        return $this->estados[$this->estadoId];
    }

    /**
     * Devuelve la clase CSS del estado del capítulo.
     * @return string Clase CSS
     */
    public function getEstadoCssString()
    {
        return $this->estadosCss[$this->estadoId];
    }

    /**
     * Validación para creación/edición del capítulo.
     * @return array Array de errores
     */
    private function validate()
    {
        $config = Registry::getConfig();
        //Titulo
        if (!$this->titulo) {
            Registry::addMessage("Debes introducir un titulo", "error", "titulo");
        } elseif (Programa::getBy("titulo", $this->titulo, $this->id)) {
            Registry::addMessage("Ya existe otro programa con este nombre", "error", "titulo");
        }
        //Banner Upload
        if (isset($_FILES["banner"])) {
            try {
                //Eliminamos la antigua
                @unlink($this->getBannerPath());
                //Subimos la nueva
                $bulletProof = new BulletProof();
                $this->banner = $bulletProof
                    ->uploadDir($config->get("path").$this->path)
                    ->shrink(array("height"=>150, "width"=>510))
                    ->upload($_FILES['banner']);
            } catch (ImageUploaderException $e) {
                Registry::addMessage("Error al subir la imagen: ".$e->getMessage(), "error");
            }
        } else {
            $this->banner = null;
        }
        //Thumbnail Upload
        if (isset($_FILES["thumbnail"])) {
            try {
                //Eliminamos la antigua
                @unlink($this->getThumbnailPath());
                //Subimos la nueva
                $bulletProof = new BulletProof();
                $this->thumbnail = $bulletProof
                    ->uploadDir($config->get("path").$this->path)
                    ->shrink(array("height"=>162, "width"=>269))
                    ->upload($_FILES['thumbnail']);
            } catch (ImageUploaderException $e) {
                Registry::addMessage("Error al subir la imagen: ".$e->getMessage(), "error");
            }
        } else {
            $this->thumbnail = null;
        }

        return Registry::getMessages(true);
    }

    /**
     * Combierte el nombre a slug
     * @return string
     */
    public function slugify()
    {
        $slugify = new Cocur\Slugify\Slugify();
        $this->slug =  $slugify->slugify($this->titulo);
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
    public function preInsert($data = array())
    {
        $user = Registry::getUser();
        $this->userId = $user->id;
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
        return $this->validate();
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

    public function order()
    {
        //leemos los programas
        $programas = self::select(array("seccionId" => $this->seccionId));
        $pos = 0;
        if (count($programas)) {
            //Primero
            if ($this->order == -1) {
                $this->order = 1;
                $pos++;
            }
            //Recorremos los programas
            foreach ($programas as $programa) {
                $pos++;
                //Si hemos indicado ir aquí...
                if ($this->order == $pos) {
                    $pos++;
                }
                //Movemos la sección de posición
                $programa->order = $pos;
                $programa->update();
            }
            //Último
            if ($this->order == -2) {
                $pos++;
                $this->order = $pos;
            }
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
    public static function select($data=array(), $limit=0, $limitStart=0, &$total=null)
    {
        $db = Registry::getDb();
        //Query
        $query = "SELECT * FROM `programas` WHERE 1=1 ";
        $params = array();
        //Where
        //Búsqueda
        if ($data["search"]) {
            $query .= " AND (
                `titulo` LIKE :titulo OR
                `subtitulo` LIKE :subtitulo OR
                `descripcion` LIKE :descripcion
            ) ";
            $params[":titulo"] = "%".$data["search"]."%";
            $params[":subtitulo"] = "%".$data["search"]."%";
            $params[":descripcion"] = "%".$data["search"]."%";
        }
        //Estado
        if (isset($data["estadoId"]) && $data["estadoId"]!="-1") {
            $query .= " AND `estadoId`=:estadoId ";
            $params[":estadoId"] = $data["estadoId"];
        }
        //Sección
        if ($data["seccionId"]) {
            $query .= " AND `seccionId`=:seccionId ";
            $params[":seccionId"] = $data["seccionId"];
        }
        //Destacado
        if ($data["destacado"]) {
            $query .= " AND `destacado` = 1 ";
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
                    $results[] = new Programa($row);
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
        $config = Registry::getConfig();
        //Borramos los archivos
        if ($this->banner) {
            //@unlink($config->get("path").$this->path.$this->banner);
        }
        if ($this->thumbnail) {
            //@unlink($config->get("path").$this->path.$this->thumbnail);
        }
    }
}
