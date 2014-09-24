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
     * Id del estado de la subida al CDN
     * @var int
     */
    public $estadoCdnId;
    /**
     * Id del CDN
     * @var string
     */
    public $cdnId;
    /**
     * Thumbnail (URL de Wistia)
     * @var string
     */
    public $thumbnail;
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
     * Texto
     * @var string
     */
    public $texto;
    /**
     * Duración
     * @var string
     */
    public $duracion;
    /**
     * ComunidadId
     * @var string
     */
    public $comunidadId;
    /**
     * Localización
     * @var string
     */
    public $localizacion;
    /**
     * long
     * @var string
     */
    public $long;
    /**
     * lat
     * @var string
     */
    public $lat;
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
     * Nº total de likes recibidos
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
     * Tipos de estado de CDN
     * @var array
     */
    public $estadosCdn = array(
        0 => "Pendiente",
        1 => "Subiendo",
        2 => "En conversión",
        3 => "Finalizada",
        4 => "Error",
    );
    /**
     * Variables reservadas (no están en la base de datos)
     * @var array
     */
    public static $reservedVarsChild = array("estados", "estadosCss", "estadosCdn");

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

    public function checkPermission($userId=null)
    {
        if (!$userId) {
            $user = Registry::getUser();
            $userId = $user->id;
        }

        return ($this->id && $userId==$this->userId);
    }

    public function getThumbnailUrl()
    {
        if ($this->thumbnail) {
            return $this->thumbnail;
        } else {
            return Url::template("img/nophotovideo.png", "tribo");
        }
    }

    public function getVideosRelacionados($limit)
    {
        return self::select(
            array(
                "categoriaId" => $this->categoriaId,
                "estadoId" => 1,
                "ignoreId" => $this->id,
                "order" => "dateInsert",
                "orderDir" => "DESC"
            ),
            $limit
        );
    }

    /**
     * Añade una visita al vídeo.
     * @return bool
     */
    public function addVisita()
    {
        //Creamos la visita
        $visita = new VideoVisita();
        $visita->videoId = $this->id;
        $visita->insert();
        //Actualizamos el total
        $this->visitas = VideoVisita::getTotalVisitasByVideoId($this->id);

        return $this->update();
    }

    /**
     * Comprueba si el vídeo está marcado con Like
     * @return boolean
     */
    public function isLiked()
    {
        return VideoLike::isLiked($this->id);
    }

    /**
     * Añade un like al vídeo.
     * @return bool
     */
    public function like()
    {
        //Creamos el like
        $like = new VideoLike();
        $like->videoId = $this->id;
        $like->insert();
        //Actualizamos el total
        $this->likes = VideoLike::getTotalLikesByVideoId($this->id);

        return $this->update();
    }

    /**
     * Quita un like al vídeo.
     * @return bool
     */
    public function unlike()
    {
        //Eliminamos el like
        VideoLike::unlike($this->id);
        //Actualizamos el total
        $this->likes = VideoLike::getTotalLikesByVideoId($this->id);

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

    public function validate()
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
        if ($this->estadoId == 1 && (!$this->videoArchivoId && !$this->cdnId)) {
            Registry::addMessage("No puedes publicar un vídeo si no contiene archivos verificados", "error");
        }
    }

    /**
     * Validación de creación.
     * @return array Errores
     */
    public function validateInsert($data = array())
    {
        $this->validate();

        //Archivo?
        if (!$data["file"] && !$this->cdnId) {
            Registry::addMessage("Debes subir un archivo", "error");
        }

        return Registry::getMessages(true);
    }

    /**
     * Setea las coordenadas y la comunidad mediante una dirección
     */
    private function setLocalizacion()
    {
        if ($this->localizacion) {

            // replace all the white space with "+" sign to match with google search pattern
            $address = str_replace(" ", "+", $this->localizacion);
            $url = "http://maps.google.es/maps/api/geocode/json?sensor=false&address=$address";
            $response = file_get_contents($url);
            //generate array object from the response from the web
            $json = json_decode($response, true);

            //Coordenadas
            $this->lat = $json['results'][0]['geometry']['location']['lat'];
            $this->long = $json['results'][0]['geometry']['location']['lng'];

            //Comunidad
            $components = $json['results'][0]['address_components'];
            if (count($components)) {
                foreach ($components as $component) {
                    if ($component["types"][0] == "administrative_area_level_1") {
                        $comunidad = @current(Comunidad::getBy("nombre", $component["long_name"]));
                        if ($comunidad->id) {
                            $this->comunidadId = $comunidad->id;
                        }
                    }
                }
            }
        }
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
        $this->setLocalizacion();
        //Video creado desde /admin
        if ($this->cdnId) {
            //Marcamos el vídeo como convertido
            $this->estadoCdnId = 3;
            //Leemos la duración
            $this->duracion = $this->getWistiaDuration();
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
     * @param  array $tagsIds Id's de las Tags a añadir
     * @return void
     */
    public function syncTags($tagsIds = array())
    {
        $actualTagsIds = VideoTag::getFieldBy("tagId", "videoId", $this->id);
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
        $this->validate();

        return Registry::getMessages(true);
    }

    /**
     * Acciones previas a la modificación.
     * @return void
     */
    public function preUpdate()
    {
        $this->dateUpdate = date("Y-m-d H:i:s");
        $this->setLocalizacion();
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
     * @return array   Objetoś vídeo
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
        //Ignorar video
        if ($data["ignoreId"]) {
            $query .= " AND `id` != :ignoreId ";
            $params[":ignoreId"] = $data["ignoreId"];
        }
        //Usuario
        if (isset($data["userId"])) {
            $query .= " AND `userId`=:userId ";
            $params[":userId"] = $data["userId"];
        }
        //Estado
        if (isset($data["estadoId"]) && $data["estadoId"]!="-1") {
            $query .= " AND `estadoId`=:estadoId ";
            $params[":estadoId"] = $data["estadoId"];
        }
        //Estado CDN
        if (isset($data["estadoCdnId"]) && $data["estadoCdnId"]!="-1") {
            $query .= " AND `estadoCdnId`=:estadoCdnId ";
            $params[":estadoCdnId"] = $data["estadoCdnId"];
        }
        //Categoría
        if ($data["categoriaId"]) {
            $query .= " AND `categoriaId`=:categoriaId ";
            $params[":categoriaId"] = $data["categoriaId"];
        }
        //Comunidad
        if ($data["comunidadId"]) {
            $query .= " AND `comunidadId`=:comunidadId ";
            $params[":comunidadId"] = $data["comunidadId"];
        }
        //Fecha
        if ($data["fecha"]) {
            $query .= " AND `dateInsert`>=:fecha ";
            $params[":fecha"] = date("Y-m-d H:i:s", strtotime($data["fecha"]));
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
        $tags = VideoTag::getBy("videoId", $this->id);
        if (is_array($tags)) {
            foreach ($tags as $tag) {
                $tag->delete();
            }
        }
        //Eliminamos las visitas
        $visitas = VideoVisita::getBy("videoId", $this->id);
        if (is_array($visitas)) {
            foreach ($visitas as $visita) {
                $visita->delete();
            }
        }
        //Eliminamos los archivos
        $archivos = VideoArchivo::getBy("videoId", $this->id);
        if (is_array($archivos)) {
            foreach ($archivos as $archivo) {
                $archivo->delete();
            }
        }
    }

    public function getWsApi()
    {
        $data = new stdclass();
        $data->id = $this->id;
        $data->estadoCdnId = $this->estadoCdnId;
        $data->cdnId = $this->cdnId;
        $data->thumbnail = $this->thumbnail;

        return $data;
    }
}
