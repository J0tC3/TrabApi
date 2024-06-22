<?php
class artigosController extends controller{

	private $dados;

	public function __construct(){
		parent::__construct();
		$this->dados = array();
	}

	public function listarTudo() {
        $limite = null;

        if(isset($_GET['limite']) && !empty($_GET['limite'])) {
            $limite = $_GET['limite'];
        }

		$artigo = new Artigos();
		$lista = $artigo->getAll($limite);

        //  // Converte o array $lista para JSON 
        $json_lista = json_encode($lista);

        // Saida do JSON data
        echo $json_lista;
	}

    // Listar artigos por titulo
    public function listarTitulo() {
        if(!(isset($_GET['titulo']) && !empty($_GET['titulo']))) return;
        
        $limite = null;

        if(isset($_GET['limite']) && !empty($_GET['limite'])) {
            $limite = $_GET['limite'];
        }

        $titulo = $_GET['titulo'];

        $artigo = new Artigos();
        $lista = $artigo->getTitulo($titulo, $limite);

        // Converte o array $lista para JSON 
        $json_lista = json_encode($lista);

        // Saida do JSON data
        echo $json_lista;
    }

    public function listarArtigoAutor() {
        if(!(isset($_GET['titulo']) && !empty($_GET['titulo'])) 
        && !(isset($_GET['autor']) && !empty($_GET['autor']))) return;
    
        // Define a página padrão como 1 se não especificada
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
    
        $limite = null;
    
        if(isset($_GET['limite']) && !empty($_GET['limite'])) {
            $limite = $_GET['limite'];
        }
    
        // Calcula o offset para a consulta com base na página atual
        $offset = ($page - 1) * $limite;
    
        $titulo = $_GET['titulo'];
        $autor = $_GET['autor'];
    
        $artigo = new Artigos();
        $lista = $artigo->getTituloAutor($titulo, $autor, $limite, $offset);
    
        // Converte o array $lista para JSON 
        $json_lista = json_encode($lista);
    
        // Saída do JSON data
        echo $json_lista;
    }
    
    // Listar artigos por autor
    public function listarAutor() {
        if(!(isset($_GET['autor']) && !empty($_GET['autor']))) return;

        $autor = $_GET['autor'];

        $artigo = new Artigos();
        $lista = $artigo->getAutor($autor);

        // Converte o array $lista para JSON 
        $json_lista = json_encode($lista);

        // Saida do JSON data
        echo $json_lista;
    }

    //Criar Artigo
    public function criarArtigo(){
        //se for verdadeiro, nao retorne, se for falso, retorne (nao execute a funcao)
        if(AuthController::checkAuth() == false) return;  

        $autor = AuthController::checkAuth();

        $autor = $autor['nome'];


        if(!(isset($_POST['titulo']) && !empty($_POST['titulo']))) return;
        if(!(isset($_POST['descricao']) && !empty($_POST['descricao']))) return;
        if(!(isset($_POST['link']) && !empty($_POST['link']))) return;

        $titulo = $_POST['titulo'];
        $descricao = $_POST['descricao'];
        $link = $_POST['link'];

        $artigo = new Artigos();
        
        $artigo->createArtigo($titulo, $descricao, $link, $autor);
        output_header(true, 'Artigo Criado');

    }

    //Excluir artigo
    public function excluirArtigo() {
        // Retorna um array com o nome do usuário caso ele exista
        $username = AuthController::checkAuth(false);
        
        if ($username == false || !(isset($_POST['id']) && !empty($_POST['id']))) {
            output_header(false, 'Usuário não autenticado ou ID do artigo não fornecido');
            return;
        }
    
        $username = $username['nome'];
        $id = $_POST['id'];
    
        $artigo = new Artigos();
        
        // Verifica se o artigo existe
        if (!$artigo->artigoExiste($id, $username)) {
            output_header(false, 'Artigo não encontrado ou não pertence ao usuário');
            return;
        }
    
        // Exclui o artigo
        $artigo->excluirArtigo($id, $username);
    
        output_header(true, 'Artigo excluído');
    }

}