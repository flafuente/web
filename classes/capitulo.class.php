<?php
class Capitulo extends Model
{
    public $id;
    public $userId;
    public $programaId;
    public $estadoId;
    public $nombre;
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

    public static $reservedVarsChild = array("estados", "estadosCss");

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

    public function validateInsert($data=array())
    {
        //Titulo
        if (!$this->titulo) {
            Registry::addMessage("Debes introducir un titulo", "error", "titulo");
        }

        return Registry::getMessages(true);
    }

    public function preInsert()
    {
        $user = Registry::getUser();
        $this->userId = $user->id;
        $this->dateInsert = date("Y-m-d H:i:s");
    }

    public function validateUpdate()
    {
        //Titulo
        if (!$this->titulo) {
            Registry::addMessage("Debes introducir un titulo", "error", "titulo");
        }

        return Registry::getMessages(true);
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
                    $results[] = new Capitulos($row);
                }

                return $results;
            }
        }
    }
}
