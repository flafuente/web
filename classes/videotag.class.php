<?php
class VideoTag extends Model
{
    public $id;
    public $videoId;
    public $tagId;
    public $dateInsert;

    public function init()
    {
        parent::$dbTable = "videos_tags";
        parent::$reservedVarsChild = self::$reservedVarsChild;
    }

    public function preInsert()
    {
        $this->dateInsert = date("Y-m-d H:i:s");
    }

    public static function deleteTag($videoId, $tagId)
    {
        $db = Registry::getDb();
        $query = "DELETE FROM `videos_tags` WHERE `videoId`=:videoId AND `tagId`=:tagId";
        $params = array(
            ":videoId" => $videoId,
            ":tagId" => $tagId
        );
        if ($db->query($query, $params)) {
            return true;
        }
    }

    public function select($data=array(), $limit=0, $limitStart=0, &$total=null)
    {
        $db = Registry::getDb();
        //Query
        $query = "SELECT * FROM `videos_tags` WHERE 1=1 ";
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
                    $results[] = new VideoTag($row);
                }

                return $results;
            }
        }
    }
}
