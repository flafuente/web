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
            $this->setData("triber", $user);
            $html = $this->view("views.triber");
            $this->render($html);
        } else {
            Url::redirect(Url::site());
        }
    }

}
