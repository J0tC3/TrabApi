<?php
class artigosController extends controller{

	private $dados;

	public function __construct(){
		parent::__construct();
		$this->dados = array();
	}

	public function index(){

		$artigo = new Artigos();
		$lista = $artigo->getAll();

		output_header(true,'Todos os artigos',$lista);
	}
        // Listar artigos por titulo
        public function listarTitulo($titulo) {
            $artigo = new Artigos();
            $lista = $artigo->getTitulo($titulo);
            output_header(true, 'Artigos com titulo ' . $titulo, $lista);
        }
        
        // Listar artigos por autor
        public function listarAutor($autor) {
            $artigo = new Artigos();
            $lista = $artigo->getAutor($autor);
            output_header(true, 'Artigos do autor ' . $autor, $lista);
        }

        //Excluir artigo
        public function excluirArtigo($id){
            $api = new Api();
            $artigo = new Artigos();
            $artigo->dropArtigo($id);
            output_header(true, 'Artigo excluido');
        }

         //Excluir artigo
        public function excluirtodosArtigo($autor){
        $api = new Api();
        $artigo = new Artigos();
        $artigo->dropTodosArtigos($autor);
                }

}