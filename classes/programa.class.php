<?php
class Programa extends Model
{
    public $id;
    public $categoriaId;
    public $userId;
    public $estadoId;
    public $banner;
    public $thumbnail;
    public $titulo;
    public $subtitulo;
    public $descripcion;
    public $dateInsert;
    public $dateUpdate;

    public $estadosCss = array(
        0 => "default",
        1 => "success",
        2 => "danger",
    );
    public $estados = array(
        0 => "No publicado",
        1 => "Publicado",
    );

    public $path = "/files/images/programas/";

    public static $reservedVarsChild = array("estados", "estadosCss", "path");

    public function init()
    {
        parent::$dbTable = "programas";
        parent::$reservedVarsChild = self::$reservedVarsChild;
    }

    public function getBannerUrl()
    {
        return Url::site($this->path.$this->banner);
    }

    public function getThumbnailUrl()
    {
        return Url::site($this->path.$this->thumbnail);
    }

    public function getEstadoString()
    {
        return $this->estados[$this->estadoId];
    }

    public function getEstadoCssString()
    {
        return $this->estadosCss[$this->estadoId];
    }

    private function validate()
    {
        $config = Registry::getConfig();
        //Titulo
        if (!$this->titulo) {
            Registry::addMessage("Debes introducir un titulo", "error", "titulo");
        }
        //Banner Upload
        if (isset($_FILES["banner"])) {
            try {
                $bulletProof = new BulletProof;
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
                $bulletProof = new BulletProof;
                $this->thumbnail = $bulletProof
                    ->uploadDir($config->get("path").$this->path)
                    ->shrink(array("height"=>245, "width"=>240))
                    ->upload($_FILES['thumbnail']);
            } catch (ImageUploaderException $e) {
                Registry::addMessage("Error al subir la imagen: ".$e->getMessage(), "error");
            }
        } else {
            $this->thumbnail = null;
        }

        return Registry::getMessages(true);
    }

    public function validateInsert()
    {
        return $this->validate();
    }

    public function preInsert()
    {
        $user = Registry::getUser();
        $this->userId = $user->id;
        $this->dateInsert = date("Y-m-d H:i:s");
    }

    public function validateUpdate()
    {
        return $this->validate();
    }

    public function preUpdate()
    {
        $this->dateUpdate = date("Y-m-d H:i:s");
    }

    public function select($data=array(), $limit=0, $limitStart=0, &$total=null)
    {
        $db = Registry::getDb();
        //Query
        $query = "SELECT * FROM `programas` WHERE 1=1 ";
        $params = array();
        //Where
        //Búsqueda
        if ($data["search"]) {
            $query .= " AND (
                `titulo` LIKE '%:titulo%' OR
                `subtitulo` LIKE '%:subtitulo%' OR
                `descripcion` LIKE '%:descripcion%'
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
                    $results[] = new Programa($row);
                }

                return $results;
            }
        }
    }

    public function postDelete()
    {
        $config = Registry::getConfig();
        //Borramos los archivos
        if ($this->banner) {
            @unset($config->get("path").$this->path.$this->banner);
        }
        if ($this->thumbnail) {
            @unset($config->get("path").$this->path.$this->thumbnail);
        }
    }
}
