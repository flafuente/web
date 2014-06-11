<?php
class Video extends Model
{
    public $id;
    public $userId;
    public $estadoId;
    public $categoriaId;
    public $titulo;
    public $descripcion;
    public $comentario;
    public $file;
    public $size;
    public $type;
    public $visitas;
    public $dateInsert;
    public $dateUpdate;

    public $categorias = array(
        1 => "Categoría 1",
        2 => "Categoría 2",
        3 => "Categoría 3"
    );
    public $estadosCss = array(
        0 => "default",
        1 => "success",
        2 => "danger",
    );
    public $estados = array(
        0 => "No aprobado",
        1 => "Aprobado",
        2 => "Rechazado",
    );
    public $path = "/files/videos/";

    public static $reservedVarsChild = array("path", "categorias", "estados", "estadosCss");

    public function init()
    {
        parent::$dbTable = "videos";
        parent::$reservedVarsChild = self::$reservedVarsChild;
    }

    public function getPath()
    {
        $config = Registry::getConfig();

        return $config->get("path")."/".$this->path."/".$this->file;
    }

    public function getCategoriaString()
    {
        return $this->categorias[$this->categoriaId];
    }

    public function addVisita()
    {
        //Creamos la visita
        $videoVisita = new VideoVisita();
        $videoVisita->videoId = $this->id;
        $videoVisita->insert();
        //Actualizamos el total
        $this->visitas = VideoVisita::getTotalVisitasByVideoId($this->id);

        return $this->update();
    }

    public function getEstadoString()
    {
        return $this->estados[$this->estadoId];
    }

    public function getEstadoCssString()
    {
        return $this->estadosCss[$this->estadoId];
    }

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
        if (!$this->file) {
            Registry::addMessage("Debes subir un archivo", "error");
        } elseif (!file_exists($this->getPath())) {
            Registry::addMessage("Error al subir el archivo. Inténtalo más tarde", "error");
        }

        return Registry::getMessages(true);
    }

    public function preInsert()
    {
        $user = Registry::getUser();
        $this->userId = $user->id;
        //File upload
        $this->size = @filesize($this->getPath());
        $this->dateInsert = date("Y-m-d H:i:s");
    }

    public function postInsert($data = array())
    {
        //Añadimos/quitamos los tags
        $this->syncTags($data["tags"]);
    }

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

        return Registry::getMessages(true);
    }

    public function preUpdate()
    {
        $this->dateUpdate = date("Y-m-d H:i:s");
    }

    public function postUpdate($data = array())
    {
        //Añadimos/quitamos los tags
        $this->syncTags($data["tags"]);
    }

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

    public function select($data=array(), $limit=0, $limitStart=0, &$total=null)
    {
        $db = Registry::getDb();
        //Query
        $query = "SELECT * FROM `videos` WHERE 1=1 ";
        //Total
        $total = count($db->Query($query));
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
            $rows = $db->Query($query);
            if (count($rows)) {
                foreach ($rows as $row) {
                    $results[] = new Video($row);
                }

                return $results;
            }
        }
    }
}
