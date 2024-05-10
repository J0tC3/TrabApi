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
			&& $password == $usuario['passcode'] ) {
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

	public function createUsuario($username, $passcode, $email) {
        //se for verdadeiro continue a execucao, se for falso, retorne (nao execute a funcao)
        if(!AuthController::checkAuth()) return;

        $create = new Users();
        $create->createUsuario($username, $passcode, $email);
    }

    public function alterUsuario($id,$username, $passcode, $email) {
        //se for verdadeiro continue a execucao, se for falso, retorne (nao execute a funcao)
        if(!AuthController::checkAuth()) return;
        
        $alter = new Users();
        $alter->alterUsuario($id,$username, $passcode, $email);
    }

    public function dropusuario($id) {
        //se for verdadeiro continue a execucao, se for falso, retorne (nao execute a funcao)
        if(!AuthController::checkAuth()) return;

        $delete = new Users();
        $dropartigos = new Artigos;

        $dropartigos->dropTodosArtigos($id);
        $delete->dropUsuario($id);
    }

}
