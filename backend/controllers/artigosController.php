<?php
class artigosController extends controller{

	private $dados;

	public function __construct(){
		parent::__construct();
		$this->dados = array();
	}

	public function listarTudo() {
        //se for verdadeiro, nao retorne, se for falso, retorne (nao execute a funcao)
        //if(!AuthController::checkAuth()) return;

		$artigo = new Artigos();
		$lista = $artigo->getAll();  

        //  // Converte o array $lista para JSON 
        $json_lista = json_encode($lista);

        // Saida do JSON data
        echo $json_lista;
	}

    // Listar artigos por titulo
    public function listarTitulo() {
        if(!(isset($_POST['titulo']) && !empty($_POST['titulo']))) return;
        
        $titulo = $_POST['titulo'];

        $artigo = new Artigos();
        $lista = $artigo->getTitulo($titulo);

        // Converte o array $lista para JSON 
        $json_lista = json_encode($lista);

        // Saida do JSON data
        echo $json_lista;
    }

    public function listarArtigoAutor() {
        if(!(isset($_POST['titulo']) && !empty($_POST['titulo'])) || !(isset($_POST['autor']) && !empty($_POST['autor']))) {
            return;
        }
        $titulo = $_POST['titulo'];
        $autor = $_POST['autor'];

        $artigo = new Artigos();
        $lista = $artigo->getTituloAutor($titulo,$autor);

        // Converte o array $lista para JSON 
        $json_lista = json_encode($lista);

        // Saida do JSON data
        echo $json_lista;
    }
    
    // Listar artigos por autor
    public function listarAutor() 
    {
    
        if(AuthController::checkAuth() == true){

        $autor = AuthController::checkAuth();

        $autor = $autor['nome'];
        }else{
        if(!(isset($_POST['autor']) && !empty($_POST['autor']))) return;
        

        $autor = $_POST['autor'];
        }
        
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
        //se for verdadeiro, nao retorne, se for falso, retorne (nao execute a funcao)
        if(!AuthController::checkAuth()) return;

        if(!(isset($_POST['id']) && !empty($_POST['id']))) return;

        $id = $_POST['id'];

        $artigo = new Artigos();
        $artigo->dropArtigo($id);

        output_header(true, 'Artigo excluido');
    }

}