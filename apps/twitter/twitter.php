<?php
//No direct access
defined('_EXE') or die('Restricted access');

class twitterController extends Controller
{
    public function init() {}

    public function index()
    {
        Url::redirect();
    }

    public function refresh()
    {
        $config = Registry::getConfig();
        $hashtag = $config->get("twitterHashtag") ? $config->get("twitterHashtag") : "#TriboTv";

        $search = array(
            "hashtag" => $hashtag,
            "order" => "fecha",
            "orderDir" => "DESC",
        );

        if (isset($_SESSION["lastTW"])) {
            $search["fechaMin"] = date("Y-m-d H:i:s", $_SESSION["lastTW"]);
        }

        $tweets = Tweet::select($search, 50);

        $data = array("html" => "");
        if (count($tweets)) {
            foreach ($tweets as $tweet) {

                ob_start();
                TwitterHelper::showTweet($tweet);
                $content = ob_get_contents();
                ob_end_clean();

                $data["html"] .= $content;
            }
        }
        $this->ajax($data);
    }
}
