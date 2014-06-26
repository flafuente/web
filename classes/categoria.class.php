<?php
class Categoria extends Model
{
    public $id;
    public $nombre;
    public $dateInsert;
    public $dateUpdate;

    public function init()
    {
        parent::$dbTable = "categorias";
        parent::$reservedVarsChild = self::$reservedVarsChild;
    }

    public function validateInsert()
    {
        //nombre
        if (!$this->nombre) {
            Registry::addMessage("Debes introducir un nombre", "error", "nombre");
        } elseif ($this->getCategoriaByNombre($this->nombre)) {
            Registry::addMessage("Ya existe una categoría con este nombre", "error", "nombre");
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
        } elseif ($this->getCategoriaByNombre($this->nombre)) {
            Registry::addMessage("Ya existe una categoría con este nombre", "error", "nombre");
        }

        return Registry::getMessages(true);
    }

    public function getCategoriaByNombre($nombre, $ignoreId=0)
    {
        $db = Registry::getDb();
        $params = array();
        $query = "SELECT * FROM `categorias` WHERE nombre = :nombre";
        $params[":nombre"] = $nombre;
        //Ignore Id
        if ($ignoreId) {
            $params[":ignoreId"] = $ignoreId;
            $query .= " AND `id` != :ignoreId";
        }
        $rows = $db->query($query, $params);
        if (count($rows)) {
            return new Categoria($rows[0]);
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
        $query = "SELECT * FROM `categorias` WHERE 1=1 ";
        $params = array();
        //Where
        if (isset($data["categoriasIds"])) {
            //INSECURE!
            $query .= " AND `id` IN (".implode(",", $data["categoriasIds"]).") ";
        }
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
            } else {
                $query .= " ORDER BY `nombre` ASC";
            }
            //Limit
            if ($limit) {
                $query .= " LIMIT ".(int) $limitStart.", ".(int) $limit;
            }
            $rows = $db->Query($query, $params);
            if (count($rows)) {
                foreach ($rows as $row) {
                    $results[] = new Categoria($row);
                }

                return $results;
            }
        }
    }
}
