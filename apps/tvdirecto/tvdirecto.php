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
        //Próximos eventos
        $this->setData("proximos", Evento::select(array(
            'fechaInicio' => date('Y-m-d H:i:s', strtotime("now")),
            'order' => 'fechaInicio',
            'orderDir' => 'ASC',),
        3));

        //Ahora
        $this->setData("ahora", current(Evento::select(array('ahora' => true), 1)));

        //View
        $html = $this->view("views.tvdirecto");

        //Render
        $this->render($html);
    }

    public function refresh()
    {
        //Próximos eventos
        $this->setData("proximos", Evento::select(array(
            'fechaInicio' => date('Y-m-d H:i:s', strtotime("now")),
            'order' => 'fechaInicio',
            'orderDir' => 'ASC',),
        3));

        //Ahora
        $this->setData("ahora", current(Evento::select(array('ahora' => true), 1)));

        $data = array();
        $data["html"]["ahora"] = $this->view("modules.ahora");
        $data["html"]["proximos"] = $this->view("modules.proximos");

        $this->ajax($data);
    }

}
