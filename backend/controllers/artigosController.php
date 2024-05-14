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

        // Convert the $lista array to JSON format
        $json_lista = json_encode($lista);

        // Output the JSON data
        echo $json_lista;
	}

    // Listar artigos por titulo
    public function listarTitulo($titulo) {
        if(!(isset($_POST['titulo']) && !empty($_POST['titulo']))) return;
        
        $titulo = $_POST['titulo'];

        $artigo = new Artigos();
        $lista = $artigo->getTitulo($titulo);

        // Convert the $lista array to JSON format
        $json_lista = json_encode($lista);

        // Output the JSON data
        echo $json_lista;
    }
    
    // Listar artigos por autor
    public function listarAutor() {
        if(!(isset($_POST['autor']) && !empty($_POST['autor']))) return;

        $autor = $_POST['autor'];

        $artigo = new Artigos();
        $lista = $artigo->getAutor($autor);

        // Convert the $lista array to JSON format
        $json_lista = json_encode($lista);

        // Output the JSON data
        echo $json_lista;
    }

    //Criar Artigo
    public function criarArtigo($titulo, $descricao, $link, $id_autor){
        //se for verdadeiro, nao retorne, se for falso, retorne (nao execute a funcao)
        if(!AuthController::checkAuth()) return;  

        $artigo = new Artigos();
        
        $artigo->createArtigo($titulo, $descricao, $link, $id_autor);
        output_header(true, 'Artigo Criado');

    }

    //Excluir artigo
    public function excluirArtigo($id) {
        //se for verdadeiro, nao retorne, se for falso, retorne (nao execute a funcao)
        if(!AuthController::checkAuth()) return;

        $artigo = new Artigos();
        $artigo->dropArtigo($id);
        output_header(true, 'Artigo excluido');
    }

    //Excluir artigo
    /*
    public function excluirtodosArtigo($autor) {
        //se for verdadeiro, nao retorne, se for falso, retorne (nao execute a funcao)
        if(!AuthController::checkAuth()) return;

        $artigo = new Artigos();
        $artigo->dropTodosArtigos($autor);
    }
    */

}