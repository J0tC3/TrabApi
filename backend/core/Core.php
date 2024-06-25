<?php
class Core{

	public function exec(){
		//criando uma instancia do roteador
		$router = new Router();

		//configurando rota de página não encontrada
		$router->addRoute('/404', array(new notfoundController(), 'index'));

		//configurar as rotas
		$router->addRoute('/criarArtigo', array(new artigosController(), 'criarArtigo'));
		$router->addRoute('/excluirArtigo', array(new artigosController(), 'excluirArtigo'));
		$router->addRoute('/editarArtigo', array(new artigosController(), 'editarArtigo'));
		$router->addRoute('/listarArtigos', array(new artigosController(), 'listarArtigos'));
		$router->addRoute('/listarArtigosDoAutor', array(new artigosController(), 'listarArtigosDoAutor'));

		$router->addRoute('/criarUsuario', array(new UsersController(), 'criarUsuario'));		
		$router->addRoute('/editarUsuario', array(new UsersController(), 'editarUsuario'));
		$router->addRoute('/getUserData', array(new UsersController(), 'getUserData'));
		$router->addRoute('/deletarUsuario', array(new UsersController(), 'deletarUsuario'));

		$router->addRoute('/checkAuth', array(new AuthController(), 'checkAuth'));
		$router->addRoute('/login', array(new AuthController(), 'login'));

		//lidando com a requisição
		$route = isset($_GET['route'])?'/'.$_GET['route']:'/';

		$router->handleRequest($route);
	}

}
