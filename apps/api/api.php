<?php
//No direct access
defined('_EXE') or die('Restricted access');

class apiControllerRouter extends Controller
{
    public function init()
    {
        //Headers
        WS::setHeaders();
    }

    public function index() {}
}
