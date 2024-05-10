<?php
class Core{

	public function exec(){
		//criando uma instancia do roteador
		$router = new Router();

		//configurando rota de página não encontrada
		$router->addRoute('/404', array(new notfoundController(), 'index'));

		//configurar as rotas
		$router->addRoute('/listarTudo', array(new artigosController(), 'listarTudo'));
		$router->addRoute('/listarTitulo', array(new artigosController(), 'listarTitulo'));
		$router->addRoute('/criarArtigo', array(new artigosController(), 'criarArtigo'));
		$router->addRoute('/listarAutor', array(new artigosController(), 'listarAutor'));
		$router->addRoute('/excluirArtigo', array(new artigosController(), 'excluirArtigo'));
		$router->addRoute('/createUsuario', array(new UsersController(), 'createUsuario'));		
		$router->addRoute('/alterUsuario', array(new UsersController(), 'alterUsuario'));
		$router->addRoute('/dropUsuario', array(new UsersController(), 'dropUsuario'));

		
		$router->addRoute('/login', array(new AuthController(), 'login'));

		//teste
		$router->addRoute('/getAll', array(new UsersController(), 'getAll'));
		//teste

		//lidando com a requisição
		$route = isset($_GET['route'])?'/'.$_GET['route']:'/';

		$router->handleRequest($route);
	}

}
