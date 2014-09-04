<?php
//No direct access
defined('_EXE') or die('Restricted access');

class tribonewsController extends Controller
{
    public function init() {}

    public function index()
    {
        $this->setData("videos", Video::select(array("estadoId" => "1", "tipoCategoriaId" => 2)));
        $html = $this->view("views.tribonews");
        $this->render($html);
    }

    public function video()
    {
        $url = Registry::getUrl();
        $video = new Video($url->vars[0]);
        if ($video->id) {
            $this->setData("video", $video);
            $html = $this->view("views.video");
            $this->render($html);
        } else {
            Url::redirect(Url::site("tribonews"));
        }
    }
}
