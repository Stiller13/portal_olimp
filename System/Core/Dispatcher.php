<?php
namespace System\Core;

use System\Core\Application;
use System\Utils\URIParser;

use System\Network\Request;
use System\Network\Response;

use System\Routing\Router;
use System\Routing\Route;
use System\Log\Logger;
use System\View\View;

/**
 * Диспетчер, обслуживает запросы
 * @author nekjine
 */
class Dispatcher {
	private $req;
	private $res;
	private $app;

	private $router;

	const BASE_CMD_CLASS = "\\System\\Core\\Command";
	const APP_CMD_PREFIX = "\\Application\\Command\\";

	public function __construct($req, $res){
		$this->req = $req;
		$this->res = $res;
		$this->router = new Router;

		$router = $this->router;
		$this->app = Application::instance();

		$this->app->set("router", $router);
		/**
		* Загружаем все маршруты в роутер
		*/
		foreach( $this->app->getData("routes")->route as $route ){
			$route_id = (string)$route["id"];
			$route_path = (string)$route["path"];
			if(isset($route["method"])){
				$route_method = (string)$route["method"];
			}else{
				$route_method = "get";
			}

			$cmd_class = (string)$route["command"];

			$route_cmd = $cmd_class;

			$params = array();
			foreach( $route->param as $param ){
				if(isset($param["pattern"])){
					$pattern = $this->app->getPatternById($param["pattern"]);
				}else{
					$pattern = (string)$param;
				}
				$params[ (string)$param["name"] ] = $pattern;
			}

			$this->router->addRoute( new Route($route_id, $route_path, $route_cmd, $params, $route_method) );
		}

		/**
		* Установить префикс для generateURL(), на случай, если система не в корневой директории веб-сервера
		* Например, если система расположена в /var/webserver/mysite.com/www/dir1/dir2/dir3,
		* то все ссылки должны будут иметь префикс "/dir1/dir2/dir3"
		*/
		$this->app->set("_url_prefix", URIParser::extractPrefix( $req->getCleanURI() ));
	}

	/**
	* Проверяет правильно ли определена команда
	* @param string $cmd_name Имя команды
	* @return void
	**/
	private function checkCommand($cmd_name){
		$refl_cmd = new \ReflectionClass($cmd_name);
		if( !$refl_cmd->isSubClassOf( self::BASE_CMD_CLASS ) ){
			throw new \Exception($cmd_name . " does not extend ".self::BASE_CMD_CLASS);
		}
	}

	/**
	* Запускает команду (если возможно) с некоторыми аргументами
	* @param string $cmd_name Имя команды
	* @param array $cmd_params Аргументы команды
	* @return mixed Результат выполнения команды
	**/
	private function invokeCommand($cmd_name, $cmd_params){
		$cmd_class_name = self::APP_CMD_PREFIX . $cmd_name;
		$this->checkCommand($cmd_class_name);
		foreach($this->app->getCommandByClass($cmd_name)->param as $p){
			$pname = (string)$p["name"];
			$preq = (int)$p["required"];
			$pdef = (string)$p;

			if( isset( $cmd_params[ $pname ] ) ){

			}else{
				if( $preq == 1 ){
					throw new \Exception("Too few command parameters");
				}else{
					$cmd_params[$pname] = $pdef;
				}
			}
		}
		$cmd = new $cmd_class_name($this->req, $cmd_params);
		return $cmd->_exec();
	}

	/**
	* Спрашивает роутер о том, какую команду запустить
	* @param array $route_params_to_return Переменная, в которую будет помещён массив параметров маршрута, например для /{a}/{b} и запроса /foo/bar будет возвращён array("a"=>"foo","b"=>"bar")
	* @return Route Объект маршрута
	**/
	private function matchRequest(&$route_params_to_return){
		$res = $this->router->match(URIParser::extractRequest( $this->req->getCleanURI() ), $this->req->getMethod());
		
		if($res == null){
			$route = $this->router->getDefaultRoute();
		}else{
			$route = $res[0];
			$route_params_to_return = $res[1];
		}
		return $route;
	}

	/**
	* Диспетчеризация
	*/
	public function dispatch(){
		$route_params = array();
		$route = $this->matchRequest($route_params);

		$cmd_to_invoke = $route->getCmd();
		$cmd_pm_to_invoke = $route_params;

		$exit = false;

		while(!$exit){

			$result = $this->invokeCommand($cmd_to_invoke, $cmd_pm_to_invoke);

			if(is_null($result)){
				$action = "render";
			}else{
				if(!isset($result["do"])){
					throw new \Exception("Command return value is incorrect");
				}
				$action = $result["do"];
			}

			switch($action){
				case "render":
					$view_name = "";
					if(!is_null($result["explicit_view_name"])){
						$view_name = $result["explicit_view_name"];
					}else{
						$cfg_cmd = $this->app->getCommandByClass($cmd_to_invoke);
						if(isset($cfg_cmd["view"])){
							$view_name = (string)$cfg_cmd["view"];
						}else{
							throw new \Exception("View for the command is not specified");
						}
					}
					$view = new View;
					$view->assign($result["view_params"]);
					
					$this->res->write( $view->render($view_name) );
					// put here global break;
					$exit = true;
				break;
				case "redirectToURI":
					$uri = $result["uri"];
					$http_status = $result["status"];
					$this->res->setRedirection($uri, $http_status);
					$exit = true;
				break;
				/*
				case "redirectToRoute":
					$exit = true;
				break;
				*/
				case "forward":
					$cmd_to_invoke = $result["command_class"];
					$cmd_pm_to_invoke = $result["command_params"];
					//Logger::log("Forward to: ".$fwd_cmd);
					//$this->invokeCommand($route->getCmd(), $fwd_pm);
				break;
				case "file":
					$file_path = $result["file_path"];
					$file_outname = $result["file_outname"];

					if (!file_exists($file_path)) {
						throw new \Exception("File not found");
					}
					if (!$result["file_outname"]) {
						$file_outname = basename($file_path);
					}
					$fsize = filesize($file_path);
					$ftime = date("D, d M Y H:i:s T", filemtime($file_path));
					$fd = @fopen($file_path, "rb");

					$this->res->get($fd, $ftime, $fsize, $file_outname);
					break;
				default: 
					throw new \Exception("Command return value is incorrect");
					$exit = true;
			}

		}
		
		//Logger::out();
	}
}