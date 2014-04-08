<?php
class Tag extends Model {

	public $id;
	public $nombre;
	public $dateInsert;
	public $dateUpdate;

	public function init(){
		parent::$dbTable = "tags";
		parent::$reservedVarsChild = self::$reservedVarsChild;
	}

	public function validateInsert(){
		//nombre
		if(!$this->nombre){
			Registry::addMessage("Debes introducir un nombre", "error", "nombre");
		}
        return Registry::getMessages(true);
	}

	public function preInsert(){
		$user = Registry::getUser();
		$this->userId = $user->id;
		$this->dateInsert = date("Y-m-d H:i:s");
	}

	public function validateUpdate(){
		//nombre
		if(!$this->nombre){
			Registry::addMessage("Debes introducir un nombre", "error", "nombre");
		}
        return Registry::getMessages(true);
	}

	public function preUpdate(){
		$this->dateUpdate = date("Y-m-d H:i:s");
	}

	public function select($data=array(), $limit=0, $limitStart=0, &$total=null){
		$db = Registry::getDb();
        //Query
		$query = "SELECT * FROM `tags` WHERE 1=1 ";
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
							$results[] = new Tag($row);
						}
						return $results;
					}
				}
			}
		}
	}
}
