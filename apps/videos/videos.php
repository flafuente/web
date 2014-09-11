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
        $this->listar();
    }

    public function pendientes()
    {
        $this->listar();
    }

    public function rechazados()
    {
        $this->listar(2);
    }

    public function emitidos()
    {
        $this->listar(1);
    }

    public function listar($estadoId = 0)
    {
        $user = Registry::getUser();

        //Pagination
        $pag = array();
        $pag['total'] = 0;
        $pag['limit'] = 3;
        $pag['limitStart'] = $_REQUEST['limitStart'];

        //Vídeos
        $this->setData("videos", Video::select(array("estadoId" => $estadoId, "userId" => $user->id), $pag['limit'], $pag['limitStart'], $pag['total']));
        $this->setData("pag", $pag);

        //Categorías
        $this->setData("categorias", Categoria::select(array("visible" => true)));

        //Tags
        $this->setData("tags", Tag::select());

        //Title
        switch ($estadoId) {
            default:
            case 0:
                $title = "Pendientes";
            break;
            case 1:
                $title = "Emitidos";
            break;
            case 2:
                $title = "Rechazados";
            break;
        }
        $this->setData("title", $title);

        //View
        $html = $this->view("views.list");
        $this->render($html);
    }

    public function nuevo()
    {
        //Vídeo
        $this->setData("video", new Video());

        //Categorías
        $this->setData("categorias", Categoria::select(
            array(
                "order" => "nombre",
                "orderDir" => "ASC",
                "visible" => true,
            )
        ));

        //Tags
        $this->setData("tags", Tag::select(
            array(
                "order" => "nombre",
                "orderDir" => "ASC"
            )
        ));
        $html = $this->view("views.nuevo");
        $this->render($html);
    }

    public function edit()
    {
        $url = Registry::getUrl();

        $video = new Video($url->vars[0]);
        if ($video->id) {
            $this->setData("video", $video);
            $data["html"] = $this->view("modules.modal");
        }
        $this->ajax($data);
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

    /**
     * Subida de archivo de video por ajax (jQuery Upload)
     */
    public function upload()
    {
        set_time_limit(0);
        //Clear error messages
        Registry::getMessages();
        //Config
        $config = Registry::getConfig();
        //Upload Handler
        new UploadHandler(
            array(
                'upload_dir' => $config->get("path")."/files/videos/",
                'upload_url' => Url::site("files/videos")."/",
                "maxNumberOfFiles" => 1,
                "accept_file_types" => "/\.(mp4|mpg|flv|mpeg|avi)$/i",
            )
        );
    }

    public function like()
    {
        $url = Registry::getUrl();

        $video = new Video($url->vars[0]);
        if ($video->id) {
            $video->like();
        }
        $this->ajax();
    }

    public function unlike()
    {
        $url = Registry::getUrl();

        $video = new Video($url->vars[0]);
        if ($video->id) {
            $video->unlike();
        }
        $this->ajax();
    }
}
