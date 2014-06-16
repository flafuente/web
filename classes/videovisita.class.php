<?php
class VideoVisita extends Model
{
    public $id;
    public $videoId;
    public $ip;
    public $dateInsert;

    public function init()
    {
        parent::$dbTable = "videos_visitas";
        parent::$reservedVarsChild = self::$reservedVarsChild;
    }

    public function preInsert()
    {
        $this->ip = $_SERVER["REMOTE_ADDR"];
        $this->dateInsert = date("Y-m-d H:i:s");
    }

    public function getVideosVisitasByVideoId($videoId)
    {
        $db = Registry::getDb();
        $params = array();
        $query = "SELECT * FROM `videos_visitas` WHERE `videoId`=:videoId";
        $params[":videoId"] = $videoId;
        $rows = $db->query($query, $params);
        if (count($rows)) {
            foreach ($rows as $row) {
                $results[] = new VideoVisita($row);
            }

            return $results;
        }
    }

    public function getTotalVisitasByVideoId($videoId=0)
    {
        if ($videoId) {
            $db = Registry::getDb();
            $params = array();
            $query = "SELECT count(DISTINCT `ip`) as `total` FROM `videos_visitas` WHERE `videoId`=:videoId";
            $params[":videoId"] = $videoId;
            $rows = $db->query($query, $params);
            if (count($rows)) {
                return $row[0]["total"];
            }
        }
    }
}
