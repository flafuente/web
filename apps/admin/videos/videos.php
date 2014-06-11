<?php
//No direct access
defined('_EXE') or die('Restricted access');

class videosController extends Controller
{
    public function init()
    {
       $url = Registry::getUrl();
        $config = Registry::getConfig();
        $config->set("template", "admin");
        $user = Registry::getUser();
        if ($user->roleId<2) {
            redirect(Url::site());
        } else {
            if (!$user->checkPermisos($url->action)) {
                redirect(Url::site());
            }
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
        $this->setData("video", new Video($url->vars[0]));
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
}
