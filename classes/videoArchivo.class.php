<?php
class VideoArchivo extends Model
{
    public $id;
    public $videoId;
    public $userId;
    public $estadoId;
    public $comentario;
    public $file;
    public $size;
    public $type;
    public $dateInsert;
    public $dateUpdate;

    public $estadosCss = array(
        0 => "default",
        1 => "success",
        2 => "danger",
    );
    public $estados = array(
        0 => "Pendiente",
        1 => "Aprobado",
        2 => "Rechazado",
    );
    public $path = "/files/videos/";

    public static $reservedVarsChild = array("path", "estados", "estadosCss");

    public function init()
    {
        parent::$dbTable = "videos_archivos";
        parent::$reservedVarsChild = self::$reservedVarsChild;
    }

    public function getPath()
    {
        $config = Registry::getConfig();

        return $config->get("path")."/".$this->path."/".$this->file;
    }

    public function getUrl()
    {
        return Url::site($this->path."/".$this->file);
    }

    public function getSizeString()
    {
        return Helper::formatBytes($this->size);
    }

    public function getEstadoString()
    {
        return $this->estados[$this->estadoId];
    }

    public function getEstadoCssString()
    {
        return $this->estadosCss[$this->estadoId];
    }

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

    public function preInsert()
    {
        //File upload
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $this->type = @finfo_file($finfo, $this->getPath());
        finfo_close($finfo);
        $this->size = @filesize($this->getPath());
        $this->dateInsert = date("Y-m-d H:i:s");
    }

    public function preUpdate()
    {
        $this->dateUpdate = date("Y-m-d H:i:s");
    }

    public static function getVideosArchivosByVideoId($videoId=0, $estadoId=null)
    {
        $db = Registry::getDb();
        $params = array();
        $query = "SELECT * FROM `videos_archivos` WHERE `videoId`=:videoId";
        $params[":videoId"] = $videoId;
        if (isset($estadoId)) {
            $query .= " AND `estadoId`:estadoId ";
            $params[":estadoId"] = $estadoId;
        }
        $rows = $db->query($query, $params);
        if (count($rows)) {
            foreach ($rows as $row) {
                $results[] = new VideoArchivo($row);
            }

            return $results;
        }
    }

    public function select($data=array(), $limit=0, $limitStart=0, &$total=null)
    {
        $db = Registry::getDb();
        //Query
        $query = "SELECT * FROM `videos_archivos` WHERE 1=1 ";
        //Params
        $params = array();
        //Where
        if ($data["videoId"]) {
            $query .= " AND videoId=:videoId ";
            $params[":videoId"] = $data["videoId"];
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

    public function postDelete()
    {
        //Eliminamos el archivo
        @unlink($this->getPath());
    }
}
