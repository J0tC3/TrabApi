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

		foreach ($lista as $usuario) {
			if($username == $usuario['username'] 
			&& $password == $usuario['password'] ) {
				return true;
			}
		}
		
		return false;
	}

	//exemplo de como usar o token para verificacao
	public function getAll() {
		if(AuthController::checkAuth()) {
			//faz algo
			echo 'deu certo';
			return;
		}

		//ta bugando essa porra, mas a intencao era avisar q n verificou
		output_header(false,'Token nao valido',array('consulte o manual da api','manual disponivel em nosso site'));
	}

}
