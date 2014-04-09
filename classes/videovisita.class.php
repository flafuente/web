<?php
class VideoVisita extends Model {

	public $id;
	public $videoId;
	public $ip;
	public $dateInsert;

	public function init(){
		parent::$dbTable = "videos_visitas";
		parent::$reservedVarsChild = self::$reservedVarsChild;
	}

	public function preInsert(){
		$this->ip = $_SERVER["REMOTE_ADDR"];
		$this->dateInsert = date("Y-m-d H:i:s");
	}

	public function getTotalVisitasByVideoId($videoId=0){
		if($videoId){
			$db = Registry::getDb();
			$query = "SELECT count(DISTINCT `ip`) as `total`
			FROM `videos_visitas` WHERE `videoId`=".(int)$videoId;
			if($db->Query($query)){
				if($db->getNumRows()){
					$row = $db->fetcharray();
					return $row["total"];
				}
			}
		}
	}
}