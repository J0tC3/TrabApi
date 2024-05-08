<?php
class Core{

	public function exec(){
		//criando uma instancia do roteador
		$router = new Router();

		//configurar as rotas
		$router->addRoute('/', array(new artigosController(), 'index'));
		$router->addRoute('/', array(new artigosController(), 'listarTitulo'));
		$router->addRoute('/', array(new artigosController(), 'listarAutor'));
		$router->addRoute('/', array(new artigosController(), 'excluirArtigo'));
		$router->addRoute('/', array(new usuarioController(), 'createUsuario'));		
		$router->addRoute('/', array(new usuarioController(), 'alterUsuario'));
		$router->addRoute('/', array(new usuarioController(), 'dropUsuario'));

		//configurando rota de página não encontrada
		$router->addRoute('/404', array(new notfoundController(), 'index'));

		$router->addRoute('/login', array(new AuthController(), 'login'));

		//lidando com a requisição
		$route = isset($_GET['route'])?'/'.$_GET['route']:'/';

		$router->handleRequest($route);
	}

}
