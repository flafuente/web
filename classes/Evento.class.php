<?php
/**
 * Modelo Evento
 *
 * @package Tribo\Modelos
 */
class Evento extends Model
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
     * Id del capítulo
     * @var int
     */
    public $capituloId;
    /**
     * Fecha de inicio (Y-m-d H:i:s)
     * @var string
     */
    public $fechaInicio;
    /**
     * Fecha fin (Y-m-d H:i:s)
     * @var string
     */
    public $fechaFin;
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
     * Init.
     * @return void
     */
    public function init()
    {
        //Tabla usada en la DB
        parent::$dbTable = "eventos";
    }

    public function getHoraInicio()
    {
        return date("H:i", strtotime($this->fechaInicio));
    }

    /**
     * Validación para creación/edición del capítulo.
     * @return array Array de errores
     */
    private function validate()
    {
        //Capitulo
        if (!$this->capituloId) {
            //Registry::addMessage("Debes seleccionar un capítulo", "error", "capituloId");
        }

        return Registry::getMessages(true);
    }

    /**
     * Validación de creación.
     * @return array Errores
     */
    public function validateInsert()
    {
        return $this->validate();
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
    }

    /**
     * Validación de modificación.
     * @return array Errores
     */
    public function validateUpdate()
    {
        return $this->validate();
    }

    /**
     * Acciones previas a la modificación.
     * @return void
     */
    public function preUpdate()
    {
        $this->dateUpdate = date("Y-m-d H:i:s");
    }

    public static function importar($eventosParrilla, $fecha)
    {
        //Eliminamos el contenido del día indicado
        $fechaInicio = $fecha." 03:00:00";
        $fechaFin = date("Y-m-d 02:59:59", strtotime($fecha." +1 day"));
        $eventosOld = self::select(array("fechaInicio" => $fechaInicio, "fechaFin" => $fechaFin));
        if (count($eventosOld)) {
            foreach ($eventosOld as $evento) {
                $evento->delete();
            }
        }

        //Añadimos los nuevos
        if (count($eventosParrilla)) {
            $last = null;
            foreach ($eventosParrilla as $eventoParrilla) {
                $evento = null;
                $capitulo = @current(Capitulo::getBy("entradaId", $eventoParrilla->entradaId));
                //Creamos el evento
                if ($capitulo->id) {
                    $evento = new Evento();
                    $evento->capituloId = $capitulo->id;
                    $evento->fechaInicio = substr($eventoParrilla->fechaInicio, 0, 19);
                    $evento->fechaFin = substr($eventoParrilla->fechaFin, 0, 19);
                    $evento->insert();
                } else {
                    //Leemos si el anterior evento era un evento vacío
                    if (!$last->capituloId && $last->id) {
                        //Actualizamos la fecha fin
                        $last->fechaFin = substr($eventoParrilla->fechaFin, 0, 19);
                        $last->update();
                    } else {
                        $evento = new Evento();
                        $evento->fechaInicio = substr($eventoParrilla->fechaInicio, 0, 19);
                        $evento->fechaFin = substr($eventoParrilla->fechaFin, 0, 19);
                        $evento->insert();
                    }
                }
                //Update fechaFin last
                if ($last) {
                    $last->fechaFin = substr($eventoParrilla->fechaInicio, 0, 19);
                    $last->update();
                }
                if ($evento) {
                    $last = $evento;
                }
            }
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
    public static function select($data = array(), $limit = 0, $limitStart = 0, &$total = null)
    {
        $db = Registry::getDb();
        //Query
        $query = "SELECT * FROM `eventos` WHERE 1=1 ";
        $params = array();
        //Where
        if (isset($data["fechaInicio"])) {
            $query .= " AND `fechaInicio` >= :fechaInicio ";
            $params[":fechaInicio"] = $data["fechaInicio"];
        }
        if (isset($data["fechaFin"])) {
            $query .= " AND `fechaFin` <= :fechaFin ";
            $params[":fechaFin"] = $data["fechaFin"];
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
                    $results[] = new Evento($row);
                }

                return $results;
            }
        }
    }
}
