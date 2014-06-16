<?php
//No direct access
defined('_EXE') or die('Restricted access');

class videosController extends Controller
{
    public function init()
    {
        //Revisamos si tiene permisos para acceder a esta sección
        $url = Registry::getUrl();
        $user = Registry::getUser();
        if (!$user->checkPermisos($url->action)) {
            redirect(Url::site());
        }
    }

    public function index()
    {
        $config = Registry::getConfig();
        $pag['total'] = 0;
        $pag['limit'] = $_REQUEST['limit'] ? $_REQUEST['limit'] : $config->get("defaultLimit");
        $pag['limitStart'] = $_REQUEST['limitStart'];
        $this->setData("results", Video::select($_REQUEST, $pag['limit'], $pag['limitStart'], $pag['total']));
        $this->setData("pag", $pag);
        $html = $this->view("views.list");
        $this->render($html);
    }

    public function edit()
    {
        $url = Registry::getUrl();
        $video = new Video($url->vars[0]);
        $this->setData("video", $video);
        if ($video->id) {
            $this->setData("videosArchivos", VideoArchivo::getVideosArchivosByVideoId($video->id));
        }
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
        $html = $this->view("views.edit");
        $this->render($html);
    }

    public function save()
    {
        $video = new Video($_REQUEST['id']);
        if ($video->id) {
            $res = $video->update($_REQUEST);
            if ($res) {
                Registry::addMessage("Video actualizado satisfactoriamente", "success", "", Url::site("admin/videos"));
            }
        } else {
            $res = $video->insert($_REQUEST);
            if ($res) {
                Registry::addMessage("Video creado satisfactoriamente", "success", "", Url::site("admin/videos"));
            }
        }
        $this->ajax();
    }

    public function delete()
    {
        $video = new Video($_REQUEST['id']);
        if ($video->id) {
            if ($video->delete()) {
                Registry::addMessage("Video eliminado satisfactoriamente", "success", "", Url::site("admin/videos"));
            }
        }
        $this->ajax();
    }

    public function saveArchivo()
    {
        $videoArchivo = new VideoArchivo($_REQUEST['id']);
        if ($videoArchivo->id) {
            $videoArchivo->estadoId = $_REQUEST["estadoId"];
            $videoArchivo->comentario = $_REQUEST["comentario"];
            if ($videoArchivo->update()) {
                Registry::addMessage("Archivo actualizado satisfactoriamente", "success");
            }
        }
    }
}
