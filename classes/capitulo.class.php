<?php
class Capitulo extends Model
{
    public $id;
    public $url;
    public $userId;
    public $programaId;
    public $videoId;
    public $estadoId;
    public $thumbnail;
    public $temporada;
    public $episodio;
    public $titulo;
    public $descripcion;
    // H:i:S
    public $duracion;
    //Y-d-m
    public $fechaEmision;
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

    public $path = "/files/images/capitulos/";

    public static $reservedVarsChild = array("estados", "estadosCss", "path");

    public function init()
    {
        parent::$dbTable = "capitulos";
        parent::$reservedVarsChild = self::$reservedVarsChild;
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
        //Programa
        if (!$this->programa) {
            Registry::addMessage("Debes seleccionar un programa", "error", "programa");
        }
        //Titulo
        if (!$this->titulo) {
            Registry::addMessage("Debes introducir un titulo", "error", "titulo");
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
        $query = "SELECT * FROM `capitulos` WHERE 1=1 ";
        $params = array();
        //Where
        //Búsqueda
        if ($data["search"]) {
            $query .= " AND `nombre` LIKE :nombre";
            $params[":nombre"] = "%".$data["search"]."%";
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
}
