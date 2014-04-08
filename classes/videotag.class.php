<?php
class VideoTag extends Model {

	public $id;
	public $videoId;
	public $tagId;
	public $dateInsert;

	public function init(){
		parent::$dbTable = "videos_tags";
		parent::$reservedVarsChild = self::$reservedVarsChild;
	}

	public function preInsert(){
		$this->dateInsert = date("Y-m-d H:i:s");
	}

	public static function deleteTag($videoId, $tagId){
		$db = Registry::getDb();
		$query = "DELETE FROM `videos_tags` WHERE `videoId`=".(int)$videoId." AND tagId=".(int)$tagId;
		if($db->Query($query)){
			return true;
		}
	}

	public function select($data=array(), $limit=0, $limitStart=0, &$total=null){
		$db = Registry::getDb();
        //Query
		$query = "SELECT * FROM `videos_tags` WHERE 1=1 ";
		//Where
		if(isset($data["videoId"])){
			$query .= " AND `videoId`=".(int)$data["videoId"];
		}
		//Total
		if($db->Query($query)){
			$total = $db->getNumRows();
			//Order
			if(isset($data['order']) && isset($data['orderDir'])){
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
