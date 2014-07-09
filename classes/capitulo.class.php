<?php
/**
 * Modelo Capítulo
 *
 * @package Tribo\Modelos
 */
class Capitulo extends Model
{
    /**
     * Id
     * @var int
     */
    public $id;
    /**
     * URL del archivo media
     * @var string
     */
    public $url;
    /**
     * Id del usuario creador
     * @var int
     */
    public $userId;
    /**
     * Id del programa asociado
     * @var int
     */
    public $programaId;
    /**
     * Id del vídeo relacionado
     * @var int
     */
    public $videoId;
    /**
     * Id del estado del capítulo
     * @var int
     */
    public $estadoId;
    /**
     * Thumbnail (filename)
     * @var string
     */
    public $thumbnail;
    /**
     * Nº de Temporada
     * @var int
     */
    public $temporada;
    /**
     * Nº de Episodio
     * @var int
     */
    public $episodio;
    /**
     * Título
     * @var string
     */
    public $titulo;
    /**
     * Descipción
     * @var string
     */
    public $descripcion;
    /**
     * Duración (H:i:s)
     * @var string
     */
    public $duracion;
    /**
     * Fecha de emisión (Y-d-m)
     * @var string
     */
    public $fechaEmision;
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
    public $path = "/files/images/capitulos/";

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
        parent::$dbTable = "capitulos";
        //Variables reservadas
        parent::$reservedVarsChild = self::$reservedVarsChild;
    }

    public function getNumero()
    {
        return $this->temporada."x".str_pad($this->episodio, 2, "0", STR_PAD_LEFT);
    }

    public function getFullTitulo()
    {
        return $this->getNumero()." - ".$this->titulo;
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
        //Programa
        if (!$this->programaId) {
            Registry::addMessage("Debes seleccionar un programa", "error", "programaId");
        }
        //Titulo
        if (!$this->titulo) {
            Registry::addMessage("Debes introducir un titulo", "error", "titulo");
        }
        //Thumbnail Upload
        if (isset($_FILES["thumbnail"])) {
            try {
                //Eliminamos la antigua
                @unlink($this->getThumbnailPath());
                //Subimos la nueva
                $bulletProof = new BulletProof;
                $this->thumbnail = $bulletProof
                    ->uploadDir($config->get("path").$this->path)
                    ->shrink(array("height"=>163, "width"=>269))
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
        $query = "SELECT * FROM `capitulos` WHERE 1=1 ";
        $params = array();
        //Where
        //Búsqueda
        if ($data["search"]) {
            $query .= " AND `nombre` LIKE :nombre";
            $params[":nombre"] = "%".$data["search"]."%";
        }
        //Programa
        if ($data["programaId"]) {
            $query .= " AND `programaId`=:programaId";
            $params[":programaId"] = $data["programaId"];
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
                    $results[] = new Capitulo($row);
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
        if ($this->thumbnail) {
            @unlink($config->get("path").$this->path.$this->thumbnail);
        }
    }
}
