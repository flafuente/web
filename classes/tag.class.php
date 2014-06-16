<?php
class Tag extends Model
{
    public $id;
    public $nombre;
    public $dateInsert;
    public $dateUpdate;

    public function init()
    {
        parent::$dbTable = "tags";
        parent::$reservedVarsChild = self::$reservedVarsChild;
    }

    public function validateInsert()
    {
        //nombre
        if (!$this->nombre) {
            Registry::addMessage("Debes introducir un nombre", "error", "nombre");
        } elseif ($this->getTabByNombre($this->nombre)) {
            Registry::addMessage("Ya existe un tag con este nombre", "error", "nombre");
        }

        return Registry::getMessages(true);
    }

    public function preInsert()
    {
        $this->dateInsert = date("Y-m-d H:i:s");
    }

    public function validateUpdate()
    {
        //nombre
        if (!$this->nombre) {
            Registry::addMessage("Debes introducir un nombre", "error", "nombre");
        } elseif ($this->getTabByNombre($this->nombre, $this->id)) {
            Registry::addMessage("Ya existe un tag con este nombre", "error", "nombre");
        }

        return Registry::getMessages(true);
    }

    public static function getTagsByVideoId($videoId=0)
    {
        $db = Registry::getDb();
        $params = array();
        $query = "SELECT * FROM `tags` WHERE `id` IN (SELECT `tagId` FROM `videos_tags` WHERE `videoId`=:videoId)";
        $params[":videoId"] = $videoId;
        $rows = $db->query($query, $params);
        if (count($rows)) {
            foreach ($rows as $row) {
                $results[] = new Tag($row);
            }

            return $results;
        }
    }

    public static function getTagsIdsByVideoId($videoId=0)
    {
        $db = Registry::getDb();
        $params = array();
        $query = "SELECT `id` FROM `tags` WHERE `id` IN (SELECT `tagId` FROM `videos_tags` WHERE `videoId`=:videoId)";
        $params[":videoId"] = $videoId;
        $rows = $db->query($query, $params);
        if (count($rows)) {
            foreach ($rows as $row) {
                $results[] = $row["tagId"];
            }

            return $results;
        }
    }

    public function getTabByNombre($nombre, $ignoreId=0)
    {
        $db = Registry::getDb();
        $params = array();
        $query = "SELECT * FROM `tags` WHERE nombre = :nombre";
        $params[":nombre"] = $nombre;
        //Ignore Id
        if ($ignoreId) {
            $params[":ignoreId"] = $ignoreId;
            $query .= " AND `id` != :ignoreId";
        }
        $rows = $db->query($query, $params);
        if (count($rows)) {
            return new Tag($rows[0]);
        }
    }

    public function preUpdate()
    {
        $this->dateUpdate = date("Y-m-d H:i:s");
    }

    public function select($data=array(), $limit=0, $limitStart=0, &$total=null)
    {
        $db = Registry::getDb();
        //Query
        $query = "SELECT * FROM `tags` WHERE 1=1 ";
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
                    $results[] = new Tag($row);
                }

                return $results;
            }
        }
    }
}
