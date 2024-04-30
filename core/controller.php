<?php
class controller{

	public function __construct(){
		global $config;
	}

	public function loadView($viewName, $viewData = array()){
		extract($viewData);
		include 'views/'.$viewName.'.php';
	}

	public function loadTemplate($viewName, $viewData = array()){
		extract($viewData);
		include 'template/template.php';
	}

}