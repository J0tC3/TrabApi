<?php
class artigosController extends controller{

	private $dados;

	public function __construct(){
		parent::__construct();
		$this->dados = array();
	}

    public function listarArtigos() {
        // Verificar se os parâmetros necessários foram enviados no corpo da requisição POST
        $input = json_decode(file_get_contents('php://input'), true);
    
        if (!(isset($input['titulo']) && !empty($input['titulo'])) 
            && !(isset($input['autor']) && !empty($input['autor']))) {
            output_header(false, 'Parâmetro "titulo" ou "autor" é obrigatório');
            return;
        }
    
        // Define a página padrão como 1 se não especificada
        $page = isset($input['page']) ? $input['page'] : 1;

        if($page < 0) {
            output_header(false, "O page deve ser maior que 0");
            return;
        }
    
        $limite = 5;
        
        if(isset($input['limite']) && !empty($input['limite'])) {
            $limite = $input['limite'];
        }

        if($limite < 0) {
            output_header(false, "Limite deve ser maior que 0");
            return;
        }
    
        // Calcula o offset para a consulta com base na página atual
        $offset = ($page - 1) * $limite;
    
        $titulo = isset($input['titulo']) ? $input['titulo'] : '';
        $autor = isset($input['autor']) ? $input['autor'] : '';
    
        $artigo = new Artigos();
        $lista = $artigo->getTituloAutor($titulo, $autor, $limite, $offset);
    
        // Converte o array $lista para JSON 
        $json_lista = json_encode($lista);
    
        // Saída do JSON
        echo $json_lista;
    }    
    
    // Listar artigos por autor
    public function listarArtigosDoAutor() {
        // Captura o corpo da requisição
        $inputJSON = file_get_contents('php://input');
        
        // Verifica se há dados no corpo da requisição
        if (!$inputJSON) {
            output_header(false, 'Dados de entrada não encontrados');
            return;
        }
    
        // Decodifica os dados JSON para um array associativo
        $input = json_decode($inputJSON, true);
    
        // Verifica se o campo 'autor' foi enviado
        if (!isset($input['autor']) || empty($input['autor'])) {
            output_header(false, 'Parâmetro "autor" é obrigatório');
            return;
        }
    
        $autor = $input['autor'];
    
        $artigo = new Artigos();
        $lista = $artigo->getAutor($autor);
    
        // Converte o array $lista para JSON 
        $json_lista = json_encode($lista);
    
        // Saída do JSON
        echo $json_lista;
    }

    //Criar Artigo
    public function criarArtigo() {
        // Verificar autenticação do usuário
        if(AuthController::checkAuth(false) == false) {
            output_header(false, 'Usuário não autenticado');
            return;
        }  
    
        // Recuperar nome do autor
        $autor = AuthController::checkAuth(false)['nome'];
    
        // Obter dados do usuário
        $users = new Users();
        $userData = $users->getUserDataByUsername($autor);
    
        // Verificar se o e-mail do usuário foi recuperado
        if (!$userData || !isset($userData['email'])) {
            output_header(false, 'Erro ao recuperar dados do usuário');
            return;
        }
        
        $email = $userData['email'];
    
        // Obter dados enviados como JSON
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true); // Decodificar JSON para array associativo
        
        // Verificar se os dados foram recebidos corretamente
        if (!$data || !isset($data['titulo']) || !isset($data['descricao']) || !isset($data['link'])) {
            output_header(false, 'Dados insuficientes ou inválidos');
            return;
        }
    
        // Sanitize inputs (se necessário)
        $titulo = htmlspecialchars($data['titulo'], ENT_QUOTES, 'UTF-8');
        $descricao = htmlspecialchars($data['descricao'], ENT_QUOTES, 'UTF-8');
        $link = filter_var($data['link'], FILTER_SANITIZE_URL);
    
        // Validar link
        if (!filter_var($link, FILTER_VALIDATE_URL)) {
            output_header(false, 'Link inválido');
            return;
        }
    
        // Criar artigo
        $artigo = new Artigos();
        $artigo->createArtigo($titulo, $descricao, $link, $autor, $email);
        output_header(true, 'Artigo Criado');
    }

    //Excluir artigo
    public function excluirArtigo() {
        // Verificar autenticação do usuário
        $username = AuthController::checkAuth(false);
        
        if ($username == false) {
            output_header(false, 'Usuário não autenticado');
            return;
        }
        
        // Obter dados da solicitação DELETE
        $input = json_decode(file_get_contents('php://input'), true);
    
        // Verificar se o ID do artigo foi fornecido
        if (!isset($input['id']) || empty($input['id'])) {
            output_header(false, 'Id do artigo vazio/não provido');
            return;
        }
    
        // Sanitizar o ID do artigo
        $id = filter_var($input['id'], FILTER_SANITIZE_NUMBER_INT);
        
        // Recuperar nome do usuário
        $username = $username['nome'];
        
        $artigo = new Artigos();
        
        // Verificar se o artigo existe
        if (!$artigo->artigoExiste($id, $username)) {
            output_header(false, 'Artigo não encontrado');
            return;
        }
        
        // Excluir o artigo
        $artigo->excluirArtigo($id, $username);
        
        output_header(true, 'Artigo excluído');
    }
    
    //Editar Artigo
    public function editarArtigo() {
        // Verificar autenticação do usuário
        $username = AuthController::checkAuth(false);
        
        if ($username == false) {
            output_header(false, 'Usuário não autenticado');
            return;
        }
    
        // Verificar dados JSON
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, true);
    
        if (!(isset($input['id']) && !empty($input['id']))) {
            output_header(false, 'Id do artigo vazio/não provido');
            return;
        }
    
        if (!(isset($input['titulo']) && !empty($input['titulo'])) 
            || !(isset($input['descricao']) && !empty($input['descricao']))
            || !(isset($input['link']) && !empty($input['link']))) {
            output_header(false, 'Dados do artigo incompletos');
            return;
        }
    
        $username = $username['nome'];
        $id = $input['id'];
        $titulo = isset($input['titulo']) ? htmlspecialchars($input['titulo'], ENT_QUOTES, 'UTF-8') : null;
        $descricao = isset($input['descricao']) ? htmlspecialchars($input['descricao'], ENT_QUOTES, 'UTF-8') : null;
        $link = isset($input['link']) ? filter_var($input['link'], FILTER_SANITIZE_URL) : null;
    
        $artigo = new Artigos();
        
        // Verifica se o artigo existe
        if (!$artigo->artigoExiste($id, $username)) {
            output_header(false, 'Artigo não encontrado ou não pertence ao usuário');
            return;
        }
    
        // Edita o artigo
        try {
            $artigo->editarArtigo($id, $titulo, $descricao, $link, $username);
            output_header(true, 'Artigo atualizado com sucesso');
        } catch (Exception $e) {
            output_header(false, 'Erro ao atualizar artigo: ' . $e->getMessage());
        }
    }
}