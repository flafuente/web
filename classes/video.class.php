<?php
class Video extends Model {

	public $id;
	public $userId;
	public $estadoId;
	public $categoriaId;
	public $titulo;
	public $descripcion;
	public $file;
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
		0 => "No aprovado",
		1 => "Aprovado",
		2 => "Rechazado",
	);

	public static $reservedVarsChild = array("categorias", "estados", "estadosCss");

	public function init(){
		parent::$dbTable = "videos";
		parent::$reservedVarsChild = self::$reservedVarsChild;
	}

	public function getCategoriaString(){
		return $this->categorias[$this->categoriaId];
	}

	public function getEstadoString(){
		return $this->estados[$this->estadoId];
	}

	public function getEstadoCssString(){
		return $this->estadosCss[$this->estadoId];
	}

	public function validateInsert(){
		//Titulo
		if(!$this->titulo){
			Registry::addMessage("Debes introducir un titulo", "error", "titulo");
		}
        return Registry::getMessages(true);
	}

	public function preInsert(){
		$user = Registry::getUser();
		$this->userId = $user->id;
		$this->dateInsert = date("Y-m-d H:i:s");
	}

	public function validateUpdate(){
		//Titulo
		if(!$this->titulo){
			Registry::addMessage("Debes introducir un titulo", "error", "titulo");
		}
        return Registry::getMessages(true);
	}

	public function preUpdate(){
		$this->dateUpdate = date("Y-m-d H:i:s");
	}

	public function select($data=array(), $limit=0, $limitStart=0, &$total=null){
		$db = Registry::getDb();
        //Query
		$query = "SELECT * FROM `videos` WHERE 1=1 ";
		//Where
		if($data["estadoId"]){
			$query .= " AND estadoId=".(int)$data["estadoId"];
		}
		//Total
		if($db->Query($query)){
			$total = $db->getNumRows();
			//Order
			if($data['order'] && $data['orderDir']){
				//Secure Field
				$orders = array("ASC", "DESC");
				if(@in_array($data['order'], array_keys(get_class_vars(__CLASS__))) && in_array($data['orderDir'], $orders)){
					$query .= " ORDER BY `".mysql_real_escape_string($data['order'])."` ".mysql_real_escape_string($data['orderDir']);
				}
			}
			//Limit
			if($limit){
				$query .= " LIMIT ".(int)$limitStart.", ".(int)$limit;
			}
			if($total){
				if($db->Query($query)){
					if($db->getNumRows()){
						$rows = $db->loadArrayList();
						foreach($rows as $row){
							$results[] = new Video($row);
						}
						return $results;
					}
				}
			}
		}
	}
}
