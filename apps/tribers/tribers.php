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
            $uvideos = Video::select(array("userId" => $user->id, "estadoId" => "1"));
            $this->setData("triber", $user);
            $this->setData("videos", $uvideos);
            $html = $this->view("views.triber");

            $this->render($html);
        } else {
            Url::redirect(Url::site());
        }
    }

}
