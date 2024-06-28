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

	public function criarUsuario() {
		// Captura o corpo da requisição
		$inputJSON = file_get_contents('php://input');
		
		// Verifica se há dados no corpo da requisição
		if (!$inputJSON) {
			output_header(false, 'Dados de entrada não encontrados');
			return;
		}
	
		// Decodifica os dados JSON para um array associativo
		$input = json_decode($inputJSON, true);
	
		// Verifica se todos os campos necessários foram enviados
		if (!isset($input['username']) || empty($input['username']) ||
			!isset($input['passcode']) || empty($input['passcode']) ||
			!isset($input['email']) || empty($input['email'])) {
			
			output_header(false, 'Dados incompletos');
			return;
		}
	
		$username = $input['username'];
		$passcode = $input['passcode'];
		$email = $input['email'];
	
		$users = new UsersController();
		
		// Cria um novo usuário
		$user = new Users();

		$lista = $user->getAll();

		foreach ($lista as $usuario) {
			if($username == $usuario['username'] || $email == $usuario['email']) {
				output_header(false, 'Email ou nome de usuario já cadastrado, tente novamente');
				return;
			}
		}

		$user->criarUsuario($username, $passcode, $email);
	
		output_header(true, 'Usuário criado com sucesso');
	}

	public function editarUsuario() {
		// Captura o corpo da requisição
		$inputJSON = file_get_contents('php://input');
		
		// Verifica se há dados no corpo da requisição
		if (!$inputJSON) {
			output_header(false, 'Dados de entrada não encontrados');
			return;
		}
	
		// Decodifica os dados JSON para um array associativo
		$input = json_decode($inputJSON, true);
	
		// Verifica se os campos necessários estão presentes
		if (!(isset($input['username']) && !empty($input['username']))
			|| !(isset($input['passcode']) && !empty($input['passcode']))
			|| !(isset($input['email']) && !empty($input['email']))) {
			output_header(false, 'Parâmetros insuficientes');
			return;
		}
	
		// Recupera os dados do usuário autenticado
		$authData = AuthController::checkAuth(false);
	
		// Verifica se o usuário está autenticado
		if ($authData === false) {
			output_header(false, 'Token não válido ou usuário não autenticado');
			return;
		}
	
		// Obtém o nome de usuário autenticado
		$username = $input['username'];
		$passcode = $input['passcode'];
		$email = $input['email'];
	
		$artigos = new Artigos();
		$user = new Users();
		$lista = $user->getAll();

		foreach ($lista as $usuario) {
			if($username == $usuario['username'] || $email == $usuario['email']) {
				output_header(false, 'Email ou nome de usuário ja cadastrado, tente novamente');
				return;
			}
		}
	
		// Obtém o ID do usuário a partir dos dados autenticados
		$userData = $user->getUserDataByUsername($authData['nome']);
		$id = $userData['id_user'];
	
		// Obtém os valores antigos do autor e do email
		$oldAutor = $userData['username'];
		$oldEmail = $userData['email'];
	
		// Executa as operações de atualização nos artigos e no usuário
		$artigos->editarAutorEmailAutor($oldAutor, $oldEmail, $username, $email);
		$user->alterUsuario($id, $username, $passcode, $email);
	
		// Retorna sucesso
		output_header(true, 'Dados do usuário atualizado com sucesso');
	}

	public function deletarUsuario() {
		// Verifica se o usuário está autenticado
		$authData = AuthController::checkAuth(false);
	
		if (!$authData) {
			output_header(false, 'Token inválido ou usuário não autenticado');
			return;
		}
	
		$username = $authData['nome'];
	
		// Obtém o ID do usuário
		$user = new Users();
		$userData = $user->getUserDataByUsername($username);
	
		if (!$userData) {
			output_header(false, 'Erro ao recuperar dados do usuário');
			return;
		}
	
		$userId = $userData['id_user'];
	
		// Deleta todos os artigos do usuário
		$artigos = new Artigos();
		$artigos->dropTodosArtigos($username);
	
		// Deleta o usuário
		$user->dropUsuario($userId);
	
		output_header(true, 'Usuário excluído com sucesso');
	}

	public function getUserData() {
		// Verifica se o método HTTP utilizado é GET
		if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
			output_header(false, 'Método não permitido');
			return;
		}
	
		// Verifica se o usuário está autenticado
		$authData = AuthController::checkAuth(false);
	
		if ($authData === false) {
			output_header(false, 'Token não válido');
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
