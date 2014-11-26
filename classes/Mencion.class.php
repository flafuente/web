<?php

/**
 * Clase de Mención
 */
class Mencion extends Model
{

    /**
     * Id
     * @var int
     */
    public $id;

    /**
     * UserId
     * @var int
     */
    public $userId;

    /**
     * Orden
     * @var int
     */
    public $order;

    /**
     * Id del estado del capítulo
     * @var int
     */
    public $estadoId;

    /**
     * Titulo
     * @var string
     */
    public $titulo;

    /**
     * Descripcion
     * @var string
     */
    public $descripcion;

    /**
     * Imagen
     * @var string
     */
    public $imagen;

    /**
     * Link
     * @var string
     */
    public $link;

    /**
     * Archivo
     * @var string
     */
    public $archivo;

    /**
     * DateInsert
     * @var datetime
     */
    public $dateInsert;

    /**
     * DateUpdate
     * @var datetime
     */
    public $dateUpdate;

    /**
     * Clases CSS de los estados
     * @var array
     */
    public $estadosCss = array(
        0 => "default",
        1 => "success",
    );

    /**
     * Tipos de estado
     * @var array
     */
    public $estados = array(
        0 => "No publicada",
        1 => "Publicada",
    );

    /**
     * Ruta de las imágenes
     * @var string
     */
    public $pathImagenes = "/files/images/menciones/";

    /**
     * Ruta de los archivos
     * @var string
     */
    public $pathArchivos = "/files/files/menciones/";

    /**
     * Textos traducibles
     * @var array
     */
    public $locations = array("titulo", "descripcion|textarea");

    /**
     * Variables reservadas (no están en la base de datos)
     * @var array
     */
    public static $reservedVarsChild = array("estados", "estadosCss", "pathImagenes", "locations", "pathArchivos");

    /**
     * Class initialization
     *
     * @return void
     */
    public function init()
    {
        parent::$dbTable = "menciones";
        parent::$reservedVarsChild = self::$reservedVarsChild;
    }

    public function getLink()
    {
        if (substr($this->link, 0, 4) != "http") {
            return "http://".$this->link;
        } else {
            return $this->link;
        }
    }

    public function getEstadoString()
    {
        return $this->estados[$this->estadoId];
    }

    public function getEstadoCssString()
    {
        return $this->estadosCss[$this->estadoId];
    }

    /**
     * Devuelve la ruta de la imágen.
     * @return string
     */
    public function getImagenPath()
    {
        $config = Registry::getConfig();

        return $config->get("path").$this->pathImagenes.$this->imagen;
    }

    /**
     * Devuelve la URL del Thumbnail.
     * @return string
     */
    public function getImagenUrl()
    {
        //Imágen
        if ($this->imagen) {
            return Url::site($this->pathImagenes.$this->imagen);
        }
    }

    /**
     * Devuelve la ruta del archivo.
     * @return string
     */
    public function getArchivoPath()
    {
        $config = Registry::getConfig();

        return $config->get("path").$this->pathArchivos.$this->archivo;
    }

    /**
     * Devuelve la URL del Thumbnail.
     * @return string
     */
    public function getArchivoUrl()
    {
        //Archivo
        if ($this->archivo) {
            return Url::site($this->pathArchivos.$this->archivo);
        }
    }

    /**
     * Validation
     *
     * @return array Object Messages
     */
    public function validate($data = array())
    {
        //titulo requiered
        if (!$this->titulo) {
            Registry::addMessage("Debes introducir un titulo", "error", "titulo");
        }

        //titulo unique
        if (self::getBy("titulo", $this->titulo, $this->id)) {
            Registry::addMessage("Este titulo ya existe", "error", "titulo");
        }

        //Image Upload
        if ($data["form"] && isset($_FILES["fileImagen"]) && $_FILES["fileImagen"]["size"] > 0) {
            try {
                $config = Registry::getConfig();
                //Eliminamos la anterior
                $this->deleteImagen();
                //Subimos la nueva
                $bulletProof = new BulletProof;
                $this->imagen = $bulletProof
                    ->uploadDir($config->get("path").$this->pathImagenes)
                    ->shrink(array("height"=>147, "width"=>246))
                    ->upload($_FILES['fileImagen']);
            } catch (ImageUploaderException $e) {
                Registry::addMessage("Error al subir la imagen: ".$e->getMessage(), "error");
            }
        }

        //Archivo Upload
        if ($data["form"] && isset($_FILES["fileArchivo"]) && $_FILES["fileArchivo"]["size"] > 0) {
            try {
                //Eliminamos el anterior
                $this->deleteArchivo();
                //Subimos la nueva
                $this->archivo = substr(md5(uniqid()),0,6)."_".$_FILES["fileArchivo"]["name"];
                move_uploaded_file($_FILES["fileArchivo"]["tmp_name"], $this->getArchivoPath());
            } catch (ImageUploaderException $e) {
                Registry::addMessage("Error al subir el archivo: ".$e->getMessage(), "error");
            }
        }

    }

    /**
     * Insert validation
     *
     * @return array Object Messages
     */
    public function validateInsert($data = array())
    {
        $this->validate($data);

        //Return messages avoiding deletion
        return Registry::getMessages(true);
    }

    /**
     * Update validation
     *
     * @return array Object Messages
     */
    public function validateUpdate($data = array())
    {
        $this->validate($data);

        //Return messages avoiding deletion
        return Registry::getMessages(true);
    }

    /**
     * Pre-Insert actions
     *
     * @return void
     */
    public function preInsert($data = array())
    {
        $user = Registry::getUser();

        //Creation Date
        $this->dateInsert = date("Y-m-d H:i:s");
        //User
        $this->userId = $user->id;
        //Order
        if ($data["order"]) {
            $this->order();
        }
    }

    /**
     * Pre-Update actions
     *
     * @return void
     */
    public function preUpdate($data = array())
    {
        $user = Registry::getUser();

        //Update Date
        $this->dateUpdate = date("Y-m-d H:i:s");
        //User
        $this->userId = $user->id;
        //Order
        if ($data["order"]) {
            $this->order();
        }
    }

    public function order()
    {
        //leemos las menciones
        $menciones = Mencion::select();
        $pos = 0;
        if (count($menciones)) {
            //Primero
            if ($this->order==-1) {
                $this->order = 1;
                $pos++;
            }
            //Recorremos las menciones
            foreach ($menciones as $mencion) {
                $pos++;
                //Si hemos indicado ir aquí...
                if ($this->order==$pos) {
                    $pos++;
                }
                //Movemos la mencion de posición
                $mencion->order = $pos;
                $mencion->update();
            }
            //Último
            if ($this->order==-2) {
                $pos++;
                $this->order = $pos;
            }
        }
    }

    /**
     * Object selection
     *
     * @param array   $data       Conditionals and Order values
     * @param integer $limit      Limit
     * @param integer $limitStart Limit start
     * @param int     $total      Total rows found
     *
     * @return array Objects found
     */
    public static function select($data = array(), $limit = 0, $limitStart = 0, &$total = null)
    {
        $db = Registry::getDb();
        //Query
        $query = "SELECT * FROM `menciones` ";
        $params = array();
        //Where
        $where = " WHERE 1=1 ";
        //Estado
        if (isset($data["estadoId"])) {
            $where .= " AND estadoId = :estadoId ";
            $params[":estadoId"] = $data["estadoId"];
        }
        //Búsqueda
        if ($data["search"]) {
            $where .= " AND `titulo` LIKE :titulo ";
            $params[":titulo"] = "%".$data["search"]."%";
        }
        $query .= $where;
        //Total
        $totalQuery = "SELECT * FROM `menciones` ".$where;
        $total = count($db->Query($totalQuery, $params));
        if ($total) {
            //Order
            if ($data['order'] && $data['orderDir']) {
                //Secure Field
                $orders = array("ASC", "DESC");
                if (@in_array($data['order'], array_keys(get_class_vars(__CLASS__))) && in_array($data['orderDir'], $orders)) {
                    $query .= " ORDER BY `".$data['order']."` ".$data['orderDir'];
                }
            } else {
                $query .= " ORDER BY `order` ASC ";
            }
            //Limit
            if ($limit) {
                $query .= " LIMIT ".(int) $limitStart.", ".(int) $limit;
            }
            $rows = $db->Query($query, $params);
            if (count($rows)) {
                $results = array();
                foreach ($rows as $row) {
                    $results[] = new Mencion($row);
                }

                return $results;
            }
        }
    }

    /**
     * Acciones posteriores a la eliminación.
     * @return void
     */
    public function postDelete()
    {
        $this->deleteImagen();
        $this->deleteArchivo();
    }

    private function deleteImagen()
    {
        if ($this->imagen) {
            return @unlink($this->getImagenPath());
        }
        $this->imagen = "";
    }

    private function deleteArchivo()
    {
        if ($this->archivo) {
            return @unlink($this->getArchivoPath());
        }
        $this->archivo = "";
    }
}
