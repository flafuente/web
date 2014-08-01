<?php
//No direct access
defined('_EXE') or die('Restricted access');

class tribonewsController extends Controller {

	public function init(){}

	public function index(){
		$html = $this->view("views.tribonews");
		$this->render($html);
	}
}
