<?php
class UsersController extends controller{

	private $dados;

	public function __construct(){
		parent::__construct();
		$this->dados = array();
	}

	public function userExists($username, $passcode) {
		$user = new Users();
		$lista = $user->getAll();

		foreach ($lista as $usuario) {
			if($username == $usuario['username'] && $passcode == $usuario['passcode']) {
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

	public function createUsuario() {
		if(!(isset($_POST['username']) && !empty($_POST['username']))
		|| !(isset($_POST['passcode']) && !empty($_POST['passcode']))
		|| !(isset($_POST['email']) && !empty($_POST['email']))){ return;
	}
		$username = $_POST['username'];
		$passcode = $_POST['passcode'];
		$email = $_POST['email'];

		$users = new UsersController();

		if($users->userExists($username, $passcode)) {
			$response = ['msg' => "Usuário já existe"];
			
			// Converte o array $response para JSON 
			echo json_encode($response);
			return;
		}
		
		// Cria um novo usuário
		$create = new Users();
		$create->criarUsuario($username, $passcode, $email);
		
		// Prepara a resposta para o usuário criado
		$response = ['msg' => "Usuário Criado"];
		
		// Converte o array $response para JSON 
		echo json_encode($response);
	}

	public function alterUsuario() {
		$authData = AuthController::checkAuth(false);

		// Verifica se o usuário está autenticado
		if ($authData == false) {
			output_header(false, 'Token não válido ou usuário não autenticado');
			return;
		}
	
		if (!(isset($_POST['username']) && !empty($_POST['username']))
			|| !(isset($_POST['passcode']) && !empty($_POST['passcode']))
			|| !(isset($_POST['email']) && !empty($_POST['email']))) {
			output_header(false, 'Parâmetros insuficientes');
			return;
		}

		$username = $_POST['username'];
		$passcode = $_POST['passcode'];
		$email = $_POST['email'];

		$user = new Users();
		$userData = $user->getUserDataByUsername($authData['nome']);
	
		$id = $userData['id_user'];

		$alter = new Users();
		$alter->alterUsuario($id, $username, $passcode, $email);
	
		output_header(true, 'Usuário atualizado com sucesso');
	}

    public function dropusuario() {
        if(!(isset($_POST['$id']) && !empty($_POST['$id']))) return;

		$id = $_POST['$id'];

        $delete = new Users();
        $dropartigos = new Artigos;

        $dropartigos->dropTodosArtigos($id);
        $delete->dropUsuario($id);
    }

	public function getUserData() {
		// Verifica se o usuário está autenticado
		$authData = AuthController::checkAuth(false);
	
		if ($authData === false) {
			output_header(false, 'Token não válido ou usuário não autenticado');
			return;
		}

		$username = $authData['nome'];
		$user = new Users();
		$userData = $user->getUserDataByUsername($username);
	
		if ($userData) {
			echo json_encode($userData);
		} else {
			output_header(false, 'Usuário não encontrado');
		}
	}	
}
