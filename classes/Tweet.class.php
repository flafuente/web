<?php
/**
 * Modelo Tag
 *
 * @package Tribo\Modelos
 */
class Tweet extends Model
{
    /**
     * Id
     * @var int
     */
    public $id;
    /**
     * Nombre
     * @var string
     */
    public $tweet_id;
    /**
     * Fecha de creación
     * @var string
     */
    public $tweet;
    /**
     * Fecha de modificación
     * @var string
     */
    public $fecha;
    /**
     * Fecha de modificación
     * @var string
     */
    public $nombre;
    /**
     * Fecha de modificación
     * @var string
     */
    public $usuario;
    /**
     * Fecha de modificación
     * @var string
     */
    public $foto;
    /**
     * Fecha de modificación
     * @var string
     */
    public $nret;
    /**
     * Fecha de modificación
     * @var string
     */
    public $rt_name;
    /**
     * Fecha de modificación
     * @var string
     */
    public $rt_image;
    /**
     * Fecha de modificación
     * @var string
     */
    public $rt_usuario;

    /**
     * Init.
     * @return void
     */
    public function init()
    {
        //Tabla usada en la DB
        parent::$dbTable = "tweets";
        //Variables reservadas
        parent::$reservedVarsChild = self::$reservedVarsChild;
    }

    /**
     * Obtiene registros de la base de datos.
     * @param  array   $data       Condicionales / ordenación
     * @param  integer $limit      Límite de resultados (Paginación)
     * @param  integer $limitStart Inicio de la limitación (Paginación)
     * @param  int     $total      Total de filas encontradas (Paginación)
     * @return array   Modelos de la clase actual
     */
    public function select($data=array(), $limit=0, $limitStart=0, &$total=null)
    {
        $db = Registry::getDb();
        //Query
        $query = "SELECT * FROM `tweets` WHERE 1=1 ";
        $params = array();
        //Where
        //Búsqueda
        if ($data["hashtag"]) {
            $query .= " AND `tweet` LIKE :hashtag";
            $params[":hashtag"] = "%".$data["hashtag"]."%";
        }
        //Fecha mín
        if ($data["fechaMin"]) {
            $query .= " AND `fecha` >= :fechaMin";
            $params[":fechaMin"] = $data["fechaMin"];
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
                    $results[] = new Tweet($row);
                }

                return $results;
            }
        }
    }

    public function getTweetAPI($search, $notweets = 50)
    {
        $config = Registry::getConfig();
        $connection = new TwitterOAuth(
            $config->get("twitter_key"),
            $config->get("twitter_secret"),
            $config->get("twitter_token"),
            $config->get("twitter_token_secret")
        );
        $params = array(
            "q" => $search,
            "result_type" => "recent",
            "count" => $notweets,
        );
        $tweets = $connection->get("https://api.twitter.com/1.1/search/tweets.json", $params);
        $tweets = json_decode(json_encode($tweets), true);
        //print_pre($tweets);
        if (!isset($tweets["errors"])) {
            return $tweets["statuses"];
        }
    }

    public function parseAPI($data)
    {
        $this->tweet_id = $data["id_str"];
        $this->fecha = date("Y-m-d H:i:s", strtotime($data["created_at"]));
        $this->nombre = $data["user"]["name"];
        $this->usuario = "@".$data["user"]["screen_name"];
        $this->foto = $data["user"]["profile_image_url"];
        $this->tweet = $data["text"];
        $this->nret = $data["retweet_count"];

        if (isset($data["retweeted_status"]["user"]["name"]) && strlen($data["retweeted_status"]["user"]["name"])>2) {
            $this->rt_name = $data["retweeted_status"]["user"]["name"];
            $this->rt_image = $data["retweeted_status"]["user"]["profile_image_url"];
        }

        if (isset($data["retweeted_status"]["user"]["screen_name"]) && strlen($data["retweeted_status"]["user"]["screen_name"])>2) {
            $this->rt_usuario = "@".$data["retweeted_status"]["user"]["screen_name"];
        }
    }
}
