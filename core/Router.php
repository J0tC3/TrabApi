<?php
class Router{
	private $routes = array();

	//metodo para adicionar uma rota
	public function addRoute($route, $callback){
		$this->routes[$route] = $callback;
	}

	//metodo para lidar com a rota atual
	public function handleRequest($route){
		if(array_key_exists($route, $this->routes)){
			$callback = $this->routes[$route];
			if(is_callable($callback)){
				call_user_func($callback);
			}else{
				echo 'Erro: Callback não função';
			}
		}else{
			header("Location: ".BASE_URL.'404');
			exit;
		}
	}
}