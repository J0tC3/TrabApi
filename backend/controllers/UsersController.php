<?php
class UsersController extends controller{

	private $dados;

	public function __construct(){
		parent::__construct();
		$this->dados = array();
	}

	public function userExists($username,$passcode) {
		$user = new Users();
		$lista = $user->getAll();

		foreach ($lista as $usuario) {
			if(($username == $usuario['username']) && ($passcode == $usuario['passcode'])) {
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

		if($users->userExists($username)) {
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
		if(!(isset($_POST['id']) && !empty($_POST['id']))
		|| !(isset($_POST['username']) && !empty($_POST['username']))
		|| !(isset($_POST['passcode']) && !empty($_POST['passcode']))
		|| !(isset($_POST['email']) && !empty($_POST['email']))) return;

		$username = $_POST['username'];
		$passcode = $_POST['passcode'];
		$email = $_POST['email'];

        $alter = new Users();
        $alter->alterUsuario($id,$username, $passcode, $email);
    }

	public function InfoUser() 
    { 
        if (AuthController::checkAuth() != false) {
            $resposta = AuthController::checkAuth();
            $autor = $resposta['nome'];
        } else {

        }
    
        $user = new Users();
        $lista = $user->InfoUser($autor);
        
        // Converte o array $lista para JSON 
        $json_lista = json_encode($lista);
        
        // Saída do JSON data
        echo $json_lista;
    }

    public function dropusuario() {
        if(!(isset($_POST['$id']) && !empty($_POST['$id']))) return;

		$id = $_POST['$id'];

        $delete = new Users();
        $dropartigos = new Artigos;

        $dropartigos->dropTodosArtigos($id);
        $delete->dropUsuario($id);
    }

}
