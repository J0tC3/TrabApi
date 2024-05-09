<?php
class Core{

	public function exec(){
		//criando uma instancia do roteador
		$router = new Router();

		//configurando rota de página não encontrada
		$router->addRoute('/404', array(new notfoundController(), 'index'));

		$router->addRoute('/login', array(new AuthController(), 'login'));

		$router->addRoute('/getAll', array(new UsersController(), 'getAll'));

		//lidando com a requisição
		$route = isset($_GET['route'])?'/'.$_GET['route']:'/';

		$router->handleRequest($route);
	}

}
