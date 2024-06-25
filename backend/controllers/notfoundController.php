<?php
class notfoundController extends controller{

	private $dados;

	public function __construct(){
		parent::__construct();
		$this->dados = array();
	}

	public function index(){

		$this->loadTemplate('404', $this->dados);
	}

}