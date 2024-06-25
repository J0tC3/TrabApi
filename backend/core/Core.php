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
		$router->addRoute('/listarArtigoAutor', array(new artigosController(), 'listarArtigoAutor'));
		$router->addRoute('/listarTitulo', array(new artigosController(), 'listarTitulo'));
		$router->addRoute('/listarAutor', array(new artigosController(), 'listarAutor'));

		$router->addRoute('/createUsuario', array(new UsersController(), 'createUsuario'));		
		$router->addRoute('/alterUsuario', array(new UsersController(), 'alterUsuario'));
		$router->addRoute('/dropUsuario', array(new UsersController(), 'dropUsuario'));
		$router->addRoute('/getUserData', array(new UsersController(), 'getUserData'));

		$router->addRoute('/checkauth', array(new AuthController(), 'checkAuth'));
		$router->addRoute('/login', array(new AuthController(), 'login'));

		//lidando com a requisição
		$route = isset($_GET['route'])?'/'.$_GET['route']:'/';

		$router->handleRequest($route);
	}

}
