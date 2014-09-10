<?php
/**
 * Modelo Archivo de Vídeo
 *
 * @package Tribo\Modelos
 */
class VideoArchivo extends Model
{
    /**
     * Id
     * @var int
     */
    public $id;
    /**
     * Id del vídeo
     * @var int
     */
    public $videoId;
    /**
     * Id del usuario creador
     * @var int
     */
    public $userId;
    /**
     * Id del estado
     * @var int
     */
    public $estadoId;
    /**
     * Id del estado de conversión
     * @var int
     */
    public $estadoConversionId;
    /**
     * Comentario
     * @var string
     */
    public $comentario;
    /**
     * Filename
     * @var string
     */
    public $file;
    /**
     * Converted file url
     * @var string
     */
    public $url;
    /**
     * Tamaño del archivo
     * @var int
     */
    public $size;
    /**
     * Tipo de archivo
     * @var string
     */
    public $type;
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
        0 => "Pendiente",
        1 => "Aprobado",
        2 => "Rechazado",
    );
    /**
     * Tipos de estado de conversión
     * @var array
     */
    public $estadosConversion = array(
        0 => "Pendiente",
        1 => "En curso",
        2 => "Finalizada",
        3 => "Error",
    );
    /**
     * Ruta de los archivos de vídeo
     * @var string
     */
    public $path = "/files/videos/";

    /**
     * Variables reservadas (no están en la base de datos)
     * @var array
     */
    public static $reservedVarsChild = array("path", "estados", "estadosCss", "estadosConversion");

    /**
     * Init.
     * @return void
     */
    public function init()
    {
        //Tabla usada en la DB
        parent::$dbTable = "videos_archivos";
        //Variables reservadas
        parent::$reservedVarsChild = self::$reservedVarsChild;
    }

    /**
     * Devuelve la ruta absoluta al archivo de vídeo.
     * @return string
     */
    public function getPath()
    {
        $config = Registry::getConfig();

        return $config->get("path")."/".$this->path."/".$this->file;
    }

    /**
     * Devuelve la URL del archivo de vídeo.
     * @return string
     */
    public function getUrl()
    {
        //Video convertido?
        if ($this->estadoConversionId == 2) {
            return $this->url;
        }

        return Url::site($this->path."/".$this->file);
    }

    /**
     * Devuelve el tamaño del archivo en formato humano.
     * @return string
     */
    public function getSizeString()
    {
        return Helper::formatBytes($this->size);
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
     * Publicar archivo de vídeo.
     * Modifica el VideoArchivoId del vídeo asociado.
     * Elimina los otros archivos de vídeo.
     * @return void
     */
    public function publicar()
    {
        //Modifica el VideoArchivoId del vídeo asociado.
        $video = new Video($this->videoId);
        $video->videoArchivoId = $this->id;
        $video->update();
        //Elimina los otros archivos de vídeo.
        $archivosInvalidos = VideoArchivo::getBy("videoId", $this->videoId);
        if (is_array($archivosInvalidos) && count($archivosInvalidos)) {
            foreach ($archivosInvalidos as $archivoInvalido) {
                if ($archivoInvalido->estadoId==2) {
                    $archivoInvalido->delete();
                }
            }
        }
    }

    /**
     * Validación de creación.
     * @return array Errores
     */
    public function validateInsert()
    {
        //Archivo?
        if (!$this->file) {
            Registry::addMessage("Debes subir un archivo", "error");
        } elseif (!file_exists($this->getPath())) {
            Registry::addMessage("Error al subir el archivo. Inténtalo más tarde", "error");
        }

        return Registry::getMessages(true);
    }

    /**
     * Acciones previas a la creación.
     * @return void
     */
    public function preInsert()
    {
        //File upload
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $this->type = @finfo_file($finfo, $this->getPath());
        finfo_close($finfo);
        $this->size = @filesize($this->getPath());
        $this->dateInsert = date("Y-m-d H:i:s");
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
    public function postUpdate()
    {
        //Publicado?
        if ($this->estadoId==1) {
            $this->publicar();
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
        $query = "SELECT * FROM `videos_archivos` WHERE 1=1 ";
        //Params
        $params = array();
        //Where
        //VideoId
        if ($data["videoId"]) {
            $query .= " AND videoId=:videoId ";
            $params[":videoId"] = $data["videoId"];
        }
        //EstadoConversionId
        if (isset($data["estadoConversionId"])) {
            $query .= " AND estadoConversionId=:estadoConversionId ";
            $params[":estadoConversionId"] = $data["estadoConversionId"];
        }
        //pendienteWistia
        if ($data["pendienteWistia"]) {
            $query .= " AND `id` IN (SELECT `videoArchivoId` FROM `videos` WHERE `estadoCdnId` = 0) ";
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
                    $results[] = new VideoArchivo($row);
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
        //Eliminamos el archivo
        $this->deleteFile();
    }

    public function deleteFile()
    {
        @unlink($this->getPath());
    }

    public function getWsApi()
    {
        $data = new stdclass();
        $data->id = $this->id;
        $data->videoId = $this->videoId;
        $data->estadoConversionId = $this->estadoConversionId;
        $data->file = $this->file;
        $data->size = $this->size;
        $data->type = $this->type;
        $data->url = $this->url;
        //Video
        $video = new Video($this->videoId);
        $data->texto = $video->texto;
        $data->titulo = $video->titulo;
        $data->descripcion = $video->descripcion;
        //Categoría
        $categoria = new Categoria($video->categoriaId);
        $data->categoria = $categoria->nombre;
        //TriboNews?
        if ($cateogria->tipoId == 2) {
            $data->categoria = "7yapvmaukr";
        }

        return $data;
    }
}
