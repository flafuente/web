<?php
//No direct access
defined('_EXE') or die('Restricted access');

class ennicController extends Controller
{
    public function init()
    {
        //Twitter
        $config = Registry::getConfig();
        $config->set("twitterHashtag", "#Tribo_tv");
    }

    public function index()
    {

        //Ahora

        //View
        $html = $this->view("views.ennic");

        //Render
        $this->render($html);
    }


}
