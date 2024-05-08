<?php
class UsersController extends controller{

	private $dados;

	public function __construct(){
		parent::__construct();
		$this->dados = array();
	}


	public function userExists($username, $password) {
		$user = new Users();
		$lista = $user->getAll();

		print_r($lista);

		foreach ($lista as $usuario) {
			if($username == $usuario['username'] 
			&& $password == $usuario['password'] ) {
				return true;
			}
		}
		
		return false;
	}

}
