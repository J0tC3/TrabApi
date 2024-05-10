<?php
class usuarioController extends controller{

	private $dados;

	public function __construct(){
		parent::__construct();
		$this->dados = array();
	}

    public function createUsuario($nome, $sexo, $bibliografia, $email){
    $create = new Usuario;
    $create->createUsuario($nome, $sexo, $bibliografia, $email);

    }

    public function alterUsuario($id,$nome, $sexo, $bibliografia, $email){
        $alter = new Usuario;
        $alter->alterUsuario($id,$nome, $sexo, $bibliografia, $email);
    
        }

    public function dropusuario($id){
        $delete = new Usuario;
        $dropartigos = new Artigos;

        $dropartigos->dropTodosArtigos($id);
        $delete->dropUsuario($id);
    }
}