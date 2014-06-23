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
        if (!$user->checkPermisos($url->app)) {
            redirect(Url::site());
        }
    }

    public function index()
    {
        $user = Registry::getUser();
        $config = Registry::getConfig();
        $pag['total'] = 0;
        $pag['limit'] = $_REQUEST['limit'] ? $_REQUEST['limit'] : $config->get("defaultLimit");
        $pag['limitStart'] = $_REQUEST['limitStart'];
        //Limitamos las categorías de los validadores
        $selectVideos = array(
            "order" => "nombre",
            "orderDir" => "ASC"
        );
        if ($user->roleId==3) {
            $categoriasIds = $user->getCategoriasIds();
            if (is_array($categoriasIds) && count($categoriasIds)) {
                $selectVideos["categoriasIds"] = $categoriasIds;
            }
        }
        $this->setData("results", Video::select($selectVideos, $pag['limit'], $pag['limitStart'], $pag['total']));
        $this->setData("pag", $pag);
        $html = $this->view("views.list");
        $this->render($html);
    }

    public function edit()
    {
        $user = Registry::getUser();
        $url = Registry::getUrl();
        $video = new Video($url->vars[0]);
        $this->setData("video", $video);
        if ($video->id) {
            $this->setData("videosArchivos", VideoArchivo::getVideosArchivosByVideoId($video->id));
        }
        //Limitamos las categorías de los validadores
        $selectCategorias = array(
            "order" => "nombre",
            "orderDir" => "ASC"
        );
        if ($user->roleId==3) {
            $categoriasIds = $user->getCategoriasIds();
            if (is_array($categoriasIds) && count($categoriasIds)) {
                $selectCategorias["categoriasIds"] = $categoriasIds;
            }
        }
        $this->setData("categorias", Categoria::select($selectCategorias));
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
