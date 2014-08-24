<?php
//No direct access
defined('_EXE') or die('Restricted access');

class videosController extends Controller
{
    public function init()
    {
        $user = Registry::getUser();
        if (!$user->id) {
            Url::redirect(Url::site("login"));
        }
    }

    public function index()
    {
        $user = Registry::getUser();
        $data = $_REQUEST;
        $data["userId"] = $user->id;
        //Emitidos
        $data["estadoId"] = 1;
        $this->setData("videosEmitidos", Video::select($data));
        //Pendientes
        $data["estadoId"] = 0;
        $this->setData("videosPendientes", Video::select($data));
        //Rechazados
        $data["estadoId"] = 2;
        $this->setData("videosRechazados", Video::select($data));
        //View
        $html = $this->view("views.list");
        $this->render($html);
    }

    public function nuevo()
    {
        $this->setData("video", new Video());
        $this->setData("categorias", Categoria::select(
            array(
                "order" => "nombre",
                "orderDir" => "ASC"
            )
        ));
        $this->setData("tags", Tag::select(
            array(
                "order" => "nombre",
                "orderDir" => "ASC"
            )
        ));
        $html = $this->view("views.nuevo");
        $this->render($html);
    }

    public function ver()
    {
        $url = Registry::getUrl();
        $video = new Video($url->vars[0]);
        if ($video->checkPermission()) {
            $this->setData("videosArchivos", VideoArchivo::getBy("videoId", $video->id));
            $this->setData("video", $video);
            $html = $this->view("views.ver");
            $this->render($html);
        } else {
            Url::redirect(Url::site(), "Video incorrecto", "error");
        }
    }

    public function save()
    {
        $video = new Video($_REQUEST["id"]);
        if (!$video->id) {
            if ($video->insert($_REQUEST)) {
                Registry::addMessage("Video enviado satisfactoriamente", "success", "", Url::site("videos"));
            }
        } else {
            if ($video->checkPermission()) {
                $user = Registry::getUser();
                //Add Video
                $videoArchivo = new VideoArchivo();
                $videoArchivo->userId = $user->id;
                $videoArchivo->videoId = $video->id;
                $videoArchivo->file = $_REQUEST["file"];
                if ($videoArchivo->insert()) {
                    Registry::addMessage("Archivo de vídeo subido satisfactoriamente", "success", "", Url::site("videos/ver/".$video->id));
                }
            } else {
                Registry::addMessage("Video incorrecto", "error");
            }
        }
        $this->ajax();
    }
}
