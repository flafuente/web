<?php
//No direct access
defined('_EXE') or die('Restricted access');

class tribonewsController extends Controller
{
    public function init() {}

    public function index($welcome = false)
    {
        //Welcome
        $this->setData("welcome", $welcome);

        //Vídeos
        $this->setData("videos", Video::select(array("estadoId" => "1")));

        $html = $this->view("views.tribonews");
        $this->render($html);
    }

    public function bienvenido()
    {
        $this->index(true);
    }

    public function historico()
    {
        //Categorías
        $this->setData("categorias", Categoria::select(array("visible" => true)));

        //Comunidades
        $this->setData("comunidades", Comunidad::select());

        //Pagination
        $pag = array();
        $pag['total'] = 0;
        $pag['limit'] = 5;
        $pag['limitStart'] = $_REQUEST['limitStart'];

        //Vídeos
        $data = $_REQUEST;
        $data["estadoId"] = 1;
        $this->setData("videos", Video::select($data, $pag['limit'], $pag['limitStart'], $pag['total']));
        $this->setData("pag", $pag);

        $html = $this->view("views.historico");
        $this->render($html);
    }

    public function video()
    {
        $url = Registry::getUrl();
        $video = new Video($url->vars[0]);
        if ($video->id) {

            //Añadimos una visita
            $video->addVisita();

            //Videos relacionados
            $this->setData("relacionados", $video->getVideosRelacionados(3));

            $this->setData("video", $video);
            $html = $this->view("views.video");
            $this->render($html);

        } else {
            Url::redirect(Url::site("tribonews"));
        }
    }
    public function like()
    {
        //Accion Like
        $url = Registry::getUrl();

        $video = new Video($url->vars[0]);
        if ($video->id) {
            $video->like();
        }
        $this->ajax();
    }

    public function unlike()
    {
        //Accion unlike
        $url = Registry::getUrl();

        $video = new Video($url->vars[0]);
        if ($video->id) {
            $video->unlike();
        }
        $this->ajax();
    }
}
