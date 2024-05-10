<?php
class Core{

	public function exec(){
		//criando uma instancia do roteador
		$router = new Router();

		//configurando rota de página não encontrada
		$router->addRoute('/404', array(new notfoundController(), 'index'));

		//configurar as rotas
		$router->addRoute('/index', array(new artigosController(), 'index'));
		$router->addRoute('/listarTitulo', array(new artigosController(), 'listarTitulo'));
		$router->addRoute('/listarAutor', array(new artigosController(), 'listarAutor'));
		$router->addRoute('/excluirArtigo', array(new artigosController(), 'excluirArtigo'));
		$router->addRoute('/createUsuario', array(new usuarioController(), 'createUsuario'));		
		$router->addRoute('/alterUsuario', array(new usuarioController(), 'alterUsuario'));
		$router->addRoute('/dropUsuario', array(new usuarioController(), 'dropUsuario'));


		//teste
		$router->addRoute('/login', array(new AuthController(), 'login'));

		$router->addRoute('/getAll', array(new UsersController(), 'getAll'));
		//teste

		//lidando com a requisição
		$route = isset($_GET['route'])?'/'.$_GET['route']:'/';

		$router->handleRequest($route);
	}

}
