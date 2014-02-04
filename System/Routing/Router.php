<?php
namespace System\Routing;

use System\Core\Application;

/**
 * Router, он же модернизированный ControllerMap --
 * сопоставляет строку запроса с именем команды, которая должна быть выполнена
 * @author nekjine
 */
class Router {
	private $_routes = array();

	public function __construct(){

	}
	
	/**
	*
	**/
	public function match($req_uri, $method){
		foreach($this->_routes as $route){
			$res = $route->match($req_uri, $method);
			if( !is_null($res) ){
				return array($route, $res);
			}
		}
		return null;
	}

	public function getDefaultRoute(){
		if(!isset($this->_routes["default"])){
			throw new \Exception("Default route is not specified");
		}
		return $this->_routes["default"];
	}
	
	public function generateURL($route_id, $params = array()){
		$app = Application::instance();

		if(!isset($this->_routes[$route_id])){
			return null;
		}

		$route = $this->_routes[$route_id];
		$uri = $route->generateURL($params);
		return $app->get("_url_prefix") . $uri;
	}
	
	/**
	* Добавить новый маршрут
	* @param Route $route Маршрут
	*/
	public function addRoute( Route $route ){
		$this->_routes[$route->getId()] = $route;
	}
}