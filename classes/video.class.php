<?php
/**
 * Modelo Vídeo
 *
 * @package Tribo\Modelos
 */
class Video extends Model
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
     * Id del estado del vídeo
     * @var int
     */
    public $estadoId;
    /**
     * Id de la categoría
     * @var int
     */
    public $categoriaId;
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
     * Id del archivo de vídeo asociado
     * @var int
     */
    public $videoArchivoId;
    /**
     * Nº total de visitas recibidas
     * @var int
     */
    public $visitas;
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
     * Variables reservadas (no están en la base de datos)
     * @var array
     */
    public static $reservedVarsChild = array("estados", "estadosCss");

    /**
     * Init.
     * @return void
     */
    public function init()
    {
        //Tabla usada en la DB
        parent::$dbTable = "videos";
        //Variables reservadas
        parent::$reservedVarsChild = self::$reservedVarsChild;
    }

    /**
     * Añade una visita al vídeo.
     * @return bool
     */
    public function addVisita()
    {
        //Creamos la visita
        $videoVisita = new VideoVisita();
        $videoVisita->videoId = $this->id;
        $videoVisita->videoId = $this->id;
        $videoVisita->insert();
        //Actualizamos el total
        $this->visitas = VideoVisita::getTotalVisitasByVideoId($this->id);

        return $this->update();
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
     * Validación de creación.
     * @return array Errores
     */
    public function validateInsert($data=array())
    {
        //Titulo
        if (!$this->titulo) {
            Registry::addMessage("Debes introducir un titulo", "error", "titulo");
        }
        //Categoria
        if (!$this->categoriaId) {
            Registry::addMessage("Debes seleccionar una categoría", "error", "categoriaId");
        } else {
            $categoria = new Categoria($this->categoriaId);
            if (!$categoria->id) {
                Registry::addMessage("La categoría seleccionada no existe", "error", "categoriaId");
            }
        }
        //Archivo?
        if (!$data["file"]) {
            Registry::addMessage("Debes subir un archivo", "error");
        }
        //Publicado?
        if ($this->estadoId==1 && !$this->videoArchivoId) {
            Registry::addMessage("No puedes publicar un vídeo si no contiene archivos verificados", "error", "estadoId");
        }

        return Registry::getMessages(true);
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
     * Acciones posteriores a la creación.
     * @return void
     */
    public function postInsert($data = array())
    {
        $user = Registry::getUser();
        //Añadimos/quitamos los tags
        $this->syncTags($data["tags"]);
        //Add Video
        $videoArchivo = new VideoArchivo();
        $videoArchivo->userId = $user->id;
        $videoArchivo->videoId = $this->id;
        $videoArchivo->file = $data["file"];
        $videoArchivo->insert();
    }

    /**
     * Añade y quita las tags al vídeo
     * @param  array  $tagsIds Id's de las Tags a añadir
     * @return void
     */
    public function syncTags($tagsIds = array())
    {
        $actualTagsIds = Tag::getTagsIdsByVideoId($this->id);
        //Quitar
        if (count($actualTagsIds)) {
            foreach ($actualTagsIds as $tagId) {
                if ($tagId) {
                    //Si el tag no ha sido pasado por parámetro...
                    if (!@in_array($tagId, $tagsIds)) {
                        VideoTag::deleteTag($this->id, $tagId);
                    }
                }
            }
        }
        //Añadir
        if (count($tagsIds)) {
            foreach ($tagsIds as $tagId) {
                if ($tagId) {
                    //Si el tag no está actualmente...
                    if (!@in_array($tagId, $actualTagsIds)) {
                        $videoTag = new VideoTag();
                        $videoTag->videoId = $this->id;
                        $videoTag->tagId = $tagId;
                        $videoTag->insert();
                    }
                }
            }
        }
    }

    /**
     * Validación de modificación.
     * @return array Errores
     */
    public function validateUpdate()
    {
        //Titulo
        if (!$this->titulo) {
            Registry::addMessage("Debes introducir un titulo", "error", "titulo");
        }
        //Categoria
        if (!$this->categoriaId) {
            Registry::addMessage("Debes seleccionar una categoría", "error", "categoriaId");
        } else {
            $categoria = new Categoria($this->categoriaId);
            if (!$categoria->id) {
                Registry::addMessage("La categoría seleccionada no existe", "error", "categoriaId");
            }
        }
        //Publicado?
        if ($this->estadoId==1 && !$this->videoArchivoId) {
            Registry::addMessage("No puedes publicar un vídeo si no contiene archivos verificados", "error", "estadoId");
        }

        return Registry::getMessages(true);
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
     * Acciones posteriores a la modificación.
     * @return void
     */
    public function postUpdate($data = array())
    {
        //Añadimos/quitamos los tags
        $this->syncTags($data["tags"]);
    }

    /**
     * Devuelve los vídeos más vistos esta semana.
     * @param  integer $limit Límite
     * @return array Objetoś vídeo
     */
    public function getRankingSemanal($limit=5)
    {
        $db = Registry::getDb();
        $query = "SELECT videoId, count(id) as total FROM videos_visitas GROUP BY videoId ORDER BY total DESC LIMIT ".(int) $limit;
        $rows = $db->query($query);
        if (count($rows)) {
            foreach ($rows as $row) {
                $results[] = new Video($row["videoId"]);
            }

            return $results;
        }
    }

    /**
     * Obtiene registros de la base de datos.
     * @param  array    $data           Condicionales / ordenación
     * @param  integer  $limit          Límite de resultados (Paginación)
     * @param  integer  $limitStart     Inicio de la limitación (Paginación)
     * @param  int      $total          Total de filas encontradas (Paginación)
     * @return array                    Modelos de la clase actual
     */
    public function select($data=array(), $limit=0, $limitStart=0, &$total=null)
    {
        $db = Registry::getDb();
        //Query
        $query = "SELECT * FROM `videos` WHERE 1=1 ";
        $params = array();
        //Where
        if (isset($data["categoriasIds"])) {
            //INSECURE!
            $query .= " AND `categoriaId` IN (".implode(",", $data["categoriasIds"]).") ";
        }
        //Búsqueda
        if ($data["search"]) {
            $query .= " AND (
                `titulo` LIKE :titulo OR
                `descripcion` LIKE :descripcion
            ) ";
            $params[":titulo"] = "%".$data["search"]."%";
            $params[":descripcion"] = "%".$data["search"]."%";
        }
        //Estado
        if (isset($data["estadoId"]) && $data["estadoId"]!="-1") {
            $query .= " AND `estadoId`=:estadoId ";
            $params[":estadoId"] = $data["estadoId"];
        }
        //Categoría
        if ($data["categoriaId"]) {
            $query .= " AND `categoriaId`=:categoriaId ";
            $params[":categoriaId"] = $data["categoriaId"];
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
                    $results[] = new Video($row);
                }

                return $results;
            }
        }
    }

    /**
     * Acciones posteriores a la eñiminación.
     * @return void
     */
    public function postDelete()
    {
        //Eliminamos los tags
        $tags = VideoTag::getVideosTagsByVideoId($this->id);
        if (is_array($tags)) {
            foreach ($tags as $tag) {
                $tag->delete();
            }
        }
        //Eliminamos las visitas
        $visitas = VideoVisita::getVideosVisitasByVideoId($this->id);
        if (is_array($visitas)) {
            foreach ($visitas as $visita) {
                $visita->delete();
            }
        }
        //Eliminamos los archivos
        $archivos = VideoArchivo::getVideosArchivosByVideoId($this->id);
        if (is_array($archivos)) {
            foreach ($archivos as $archivo) {
                $archivo->delete();
            }
        }
    }
}
