<?php
//No direct access
defined('_EXE') or die('Restricted access');

class periodismociudadanoController extends Controller {

	public function init(){}

	public function index(){
		$html = $this->view("views.periodismociudadano");
		$this->render($html);
	}
}