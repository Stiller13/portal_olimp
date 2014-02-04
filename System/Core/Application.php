<?php
namespace System\Core;

class Application {
	static private $instance;

	/**
	* "Реестр" некоторых объектов приложения, которые могут понадобиться
	*/
	private $app_data = array();

	/**
	* Имена директорий приложения
	*/
	const DIR_VIEW = "View";
	const DIR_MODEL = "Model";
	const DIR_CONFIG = "Config";
	const DIR_COMMAND = "Command";

	/**
	* Конструктор, сразу загружает конфигурацию приложения
	*/
	private function __construct(){
		$this->loadConfig();
	}

	/**
	* @return object
	*/
	static public function instance(){
		if(!self::$instance){
			self::$instance = new Application;
		}
		return self::$instance;
	}

	/**
	* Записать в реестр
	* @param string $key
	* @param mixed $val
	* @return void
	*/
	public function set($key, $val){
		$this->app_data[$key] = $val;
	}

	/**
	* Взять из реестра
	* @param string $key
	* @return mixed
	*/
	public function get($key){
		return $this->app_data[$key];
	}

	/**
	* Взять из реестра некоторый к. элемент $scope конфигурационного объекта
	* @param string $scope к. элемент (db, routes, commands, etc.)
	* @return object
	*/
	public function getData($scope){
		$c = $this->app_data["config"];
		return $c[$scope];
	}

	/**
	* Записать конфигурационный объект
	* @param object $d Конфигурационный объект
	* @return void
	*/
	public function setData($d){
		$this->app_data["config"] = $d;
	}

	/**
	* Загрузить конфигурацию приложения
	* @return void
	*/
	private function loadConfig(){
		$loader = new \System\Config\Loader(APP.DS.self::DIR_CONFIG);
		$this->setData($loader->Load());

	}

	/**
	* Возвращает к.запись роута с указанным идентификатором
	* @param string $route_id
	* @return object|null
	*/
	public function getRouteById($route_id){
		foreach( $this->getData("routes")->route as $route ){
			if( (string)$route["id"] == $route_id ){
				return $route;
			}
		}
		return null;
	}

	/**
	* Возвращает к.запись команды с указанным классом
	* @param string $command_class
	* @return object|null
	*/
	public function getCommandByClass($command_class){
		foreach( $this->getData("commands")->command as $command ){
			if( (string)$command["class"] == $command_class ){
				return $command;
			}
		}
		return null;
	}

	/**
	* Возвращает к.запись шаблона рег. выражения с указанным идентификатором
	* @param string $pattern_id
	* @return object|null
	*/
	public function getPatternById($pattern_id){
		foreach( $this->getData("patterns")->pattern as $pattern ){
			if( (string)$pattern["id"] == $pattern_id ){
				return $pattern;
			}
		}
		return null;
	}
}