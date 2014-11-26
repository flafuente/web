<?php
//No direct access
defined('_EXE') or die('Restricted access');

class tribersController extends Controller
{
    public function init() {}

    public function index() {}

    public function ver()
    {
        $url = Registry::getUrl();

        $user = @current(User::getBy("username", $url->vars[0]));
        if ($user->id) {

            //Perfil
            $this->setData("triber", $user);

            //Vídeos del usuario
            $this->setData("videos", Video::select(array("userId" => $user->id, "estadoId" => "1")));

            //Categoría especializada
            $this->setData("especialidad", Categoria::getEspecialidadByUserId($user->id));

            $html = $this->view("views.triber");
            $this->render($html);
        } else {
            Url::redirect(Url::site());
        }
    }

}
