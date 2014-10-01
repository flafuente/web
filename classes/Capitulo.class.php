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
     * Id del estado del capítulo
     * @var int
     */
    public $estadoId;
    /**
     * Id del CDN
     * @var string
     */
    public $cdnId;
    /**
     * Thumbnail del CDN
     * @var string
     */
    public $cdnThumbnail;
    /**
     * Thumbnail (url)
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
     * Nº total de visitas recibidas
     * @var int
     */
    public $visitas;
    /**
     * Nº total de likes recibidos
     * @var int
     */
    public $likes;
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

    /**
     * Ordena un array de capítulos indexado por temporada.
     * @return array
     */
    public static function groupByTemporadas($capitulos = array())
    {
        $return = array();
        if (count($capitulos)) {
            foreach ($capitulos as $capitulo) {
                $return[$capitulo->temporada][$capitulo->episodio] = $capitulo;
            }
        }

        return $return;
    }

    public function getNext()
    {
        //Existe alguno más en esta temporada?
        $capitulo = self::getCapituloByTemporadaEpisodio($this->programaId, $this->temporada, ($this->episodio + 1));
        if ($capitulo->id) {
            return $capitulo;
        } else {
            //Existe alguno más en la temporada anterior?
            $capitulo = self::getLastCapituloByTemporada($this->programaId, ($this->temporada - 1));
            if ($capitulo->id) {
                return $capitulo;
            }
        }
    }

    public function getPrevious()
    {
        //Existe el anterior de esta temporada?
        $capitulo = self::getCapituloByTemporadaEpisodio($this->programaId, $this->temporada, ($this->episodio - 1));
        if ($capitulo->id) {
            return $capitulo;
        } else {
            //Existe alguno en la temporada siguiente?
            $capitulo = self::getFirstCapituloByTemporada($this->programaId, ($this->temporada + 1));
            if ($capitulo->id) {
                return $capitulo;
            }
        }
    }

    private static function getLastCapituloByTemporada($programaId, $temporada)
    {
        $db = Registry::getDb();
        //Query
        $query = "SELECT * FROM `capitulos` WHERE temporada = :temporada AND programaId = :programaId ORDER BY episodio DESC LIMIT 1";
        $params = array(
            ":temporada" => $temporada,
            ":programaId" => $programaId
        );
        $rows = $db->query($query, $params);
        if (count($rows)) {
            return new Capitulo($rows[0]);
        }
    }

    private static function getFirstCapituloByTemporada($programaId, $temporada)
    {
        $db = Registry::getDb();
        //Query
        $query = "SELECT * FROM `capitulos` WHERE temporada = :temporada AND programaId = :programaId ORDER BY episodio ASC LIMIT 1";
        $params = array(
            ":temporada" => $temporada,
            ":programaId" => $programaId
        );
        $rows = $db->query($query, $params);
        if (count($rows)) {
            return new Capitulo($rows[0]);
        }
    }

    private static function getCapituloByTemporadaEpisodio($programaId, $temporada, $episodio, $ignoreId = null)
    {
        $db = Registry::getDb();
        //Query
        $query = "SELECT * FROM `capitulos` WHERE temporada = :temporada AND episodio = :episodio AND programaId = :programaId ";
        if ($ignoreId) {
            $query .= " AND id != ".(int) $ignoreId;
        }
        $query .= " LIMIT 1";
        $params = array(
            ":temporada" => $temporada,
            ":episodio" => $episodio,
            ":programaId" => $programaId
        );
        $rows = $db->query($query, $params);
        if (count($rows)) {
            return new Capitulo($rows[0]);
        }
    }

    /**
     * Añade una visita al capítulo.
     * @return bool
     */
    public function addVisita()
    {
        //Creamos la visita
        $visita = new CapituloVisita();
        $visita->capituloId = $this->id;
        $visita->insert();

        //Actualizamos el total
        $this->visitas = CapituloVisita::getTotalVisitasByCapituloId($this->id);
        $this->update();

        //Actualizamos el total del programa
        $programa = new Programa($this->programaId);

        return $programa->updateVisitas();
    }

    /**
     * Comprueba si el capítulo está marcado con Like
     * @return boolean
     */
    public function isLiked()
    {
        return CapituloLike::isLiked($this->id);
    }

    /**
     * Añade un like al capítulo.
     * @return bool
     */
    public function like()
    {
        //Creamos el like
        $like = new CapituloLike();
        $like->capituloId = $this->id;
        $like->insert();

        //Actualizamos el total del capitulo
        $this->likes = CapituloLike::getTotalLikesByCapituloId($this->id);
        $this->update();

        //Actualizamos el total del programa
        $programa = new Programa($this->programaId);

        return $programa->updateLikes();
    }

    /**
     * Quita un like al capítulo.
     * @return bool
     */
    public function unlike()
    {
        //Eliminamos el like
        CapituloLike::unlike($this->id);

        //Actualizamos el total
        $this->likes = CapituloLike::getTotalLikesByCapituloId($this->id);
        $this->update();

        //Actualizamos el total del programa
        $programa = new Programa($this->programaId);

        return $programa->updateLikes();
    }

    /**
     * Devuelve el número de temporada-episodio
     * @example 2x04
     * @return string
     */
    public function getNumero()
    {
        return $this->temporada."x".str_pad($this->episodio, 2, "0", STR_PAD_LEFT);
    }

    /**
     * Devuelve el número y el título del capítulo
     * @example 2x04 - Título
     * @return string
     */
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
        //Thumbnail
        if ($this->thumbnail) {
            return Url::site($this->path.$this->thumbnail);
        //CND Thumbnail
        } elseif ($this->cdnThumbnail) {
            return $this->cdnThumbnail;
        //No-image
        } else {
            return Url::template("img/nophotovideo.png", "tribo");
        }
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
    private function validate($data = array())
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
        //Publicado sin CND?
        if ($data["estadoId"] == 1 && !$this->cdnId) {
            Registry::addMessage("No puedes publicar un episodio sin CDN", "error", "cdnId");
        }
        //Temporada y episodio existente
        $capitulo = self::getCapituloByTemporadaEpisodio($this->programaId, $this->temporada, $this->episodio, $this->id);
        if ($capitulo->id) {
            Registry::addMessage("Ya existe un capítulo con esta temporada y nº de episodio: ".$capitulo->getFullTitulo(), "error", "temporada");
        }
        //Thumbnail Upload
        if (isset($_FILES["thumbnail"]) && $_FILES["thumbnail"]["size"] > 0) {
            try {
                //Eliminamos la antigua
                $this->deleteThumbnail();
                //Subimos la nueva
                $bulletProof = new BulletProof();
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
    public function validateInsert($data = array())
    {
        return $this->validate($data);
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

        //Leemos el thumbnail del CDN
        if ($this->cdnId && !$this->cdnThumbnail) {
            $this->cdnThumbnail = $this->getWistiaThumbnail();
        }

        //Leemos la duración del CDN
        if ($this->cdnId && (!$this->duracion || $this->duracion == "00:00:00")) {
            $this->duracion = $this->getWistiaDuration();
        }

        //Wistia List
        if ($data["wistiaList"]) {
            $this->moveWistia360();
        }
    }

    /**
     * Validación de modificación.
     * @return array Errores
     */
    public function validateUpdate($data = array())
    {
        return $this->validate($data);
    }

    /**
     * Acciones previas a la modificación.
     * @return void
     */
    public function preUpdate($data = array())
    {
        $this->dateUpdate = date("Y-m-d H:i:s");

        //Leemos el thumbnail del CDN
        if ($this->cdnId && !$this->cdnThumbnail) {
            $this->cdnThumbnail = $this->getWistiaThumbnail();
        }

        //Leemos la duración del CDN
        if ($this->cdnId && (!$this->duracion || $this->duracion == "00:00:00")) {
            $this->duracion = $this->getWistiaDuration();
        }

        //Wistia List
        if ($data["wistiaList"]) {
            $this->moveWistia360();
        }
    }

    /**
     * Lee la duración de wistia.
     * @return bool
     */
    private function getWistiaDuration()
    {
        Wistia::init();
        if ($this->cdnId) {
            $json = Wistia::status($this->cdnId);
            if (is_object($json)) {
                if ($json->duration) {
                    return gmdate("H:i:s", (int) $json->duration);
                }
            }
        }
    }

    /**
     * Lee el thumbnail de wistia.
     * @return bool
     */
    private function getWistiaThumbnail()
    {
        Wistia::init();
        if ($this->cdnId) {
            $json = Wistia::status($this->cdnId);
            if (is_object($json)) {
                if ($json->thumbnail->url) {

                    // Better thumbnail
                    $json->thumbnail->url = str_replace("image_crop_resized=100x60", "image_crop_resized=640x360", $json->thumbnail->url);

                    return $json->thumbnail->url;
                }
            }
        }
    }

    private function moveWistia360()
    {
        $config = Registry::getConfig();

        //Programa con proyecto en wistia?
        $programa = new Programa($this->programaId);
        if ($programa->wistiaHash) {
            Wistia::init();
            $media = Wistia::moveMedia($this->cdnId, $programa->wistiaHash);
            if ($media) {
                //Update new CDN id
                $this->cndId = $media->hashed_id;
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
