<?php
//No direct access
defined('_EXE') or die('Restricted access');

class tvdirectoController extends Controller
{
    public function init()
    {
        //Twitter
        $config = Registry::getConfig();
        $config->set("twitterHashtag", "#TriboDirecto");
    }

    public function index()
    {
        $html = $this->view("views.tvdirecto");
        $this->render($html);
    }

}
