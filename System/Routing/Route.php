<?php
namespace System\Routing;

class Route {
	private $id;
	private $path;
	private $cmd;
	private $method;

	private $params;

	private $compiled;

	static private $param_name_regex = "/\{([a-z0-9\_]{1,32})\}/";
	static private $param_default_regex = "[a-b_0-9]";

	/**
	* @param string $regex Регулярное выражение
	**/
	static public function setDefaultRegex($regex){
		self::$param_default_regex = $regex;
	}

	/**
	* @param string $id Идентификатор маршрута
	* @param string $path Путь маршрута
	* @param string $cmd Имя класса команды для выполнения
	*/
	public function __construct($id, $path, $cmd, $params = null, $method = "get"){
		$this->id = $id;
		$this->path = $path;
		$this->cmd = $cmd;
		if(is_array($params)){
			$this->addParamRegex($params);
		}
		$this->method = $method;
	}

	/**
	* @param string $param Имя параметра
	* @param string $regex Регулярное выражение
	**/
	public function addParamRegex($param, $regex=null){
		if(!is_null($regex)){
			$this->params[$param] = $regex;
		}else{
			if(is_array($param)){
				foreach($param as $k=>$p){
					$this->params[$k] = $p;
				}
			}
		}
	}

	/**
	* @return string Скомпилированный в регулярное выражение путь маршрута
	**/
	public function getCompiled(){
		if(is_null($this->compiled)){
			$this->compile();
		}
		return $this->compiled;
	}

	public function extractParamNames(){
		$results = null;
		preg_match_all( self::$param_name_regex, $this->path, $results);
		return $results[1];
	}

	/**
	* 
	**/
	private function compile(){
		$param_default_regex =& self::$param_default_regex;
		$params =& $this->params;
		$this->compiled = preg_replace_callback(
			self::$param_name_regex, 

			function($x) use(&$params, &$param_default_regex) {
				if(is_null($param_default_regex)){
					throw new \Exception("Default regex for route params not provided");
				}

				if(!is_null($params)){
					if(isset($params[$x[1]])){
						return '('.$params[$x[1]].')';
					}
				}
				return '('.$param_default_regex.')';
			}

		, $this->path);
		$this->compiled = str_replace("/", "\/", $this->compiled);
	}

	/**
	* 
	*/
	public function match($req_uri, $method = "get"){
		if($method != $this->method){
			return null;
		}

		$matches = array();

		if(
			preg_match("/^".$this->getCompiled()."$/", $req_uri, $matches) != 1
		){
			return null;
		}

		
		$ret = array();
		$i = 1;
		foreach($this->extractParamNames() as $pName){
			$ret[$pName] = $matches[$i];
			++$i;
		}
		return $ret;
	}

	public function generateURL($params){
		foreach($this->extractParamNames() as $pName){
			if(!isset($params[$pName])){
				return null;
			}else{
				if(isset($this->params[$pName])){
					$pattern = $this->params[$pName];
				}else{
					$pattern = self::$param_default_regex;
				}
				if( preg_match("/".$pattern."/", $params[$pName]) == 0 ){
					return null;
				}
			}
		}
		$uri = preg_replace_callback(
			self::$param_name_regex, 

			function($x) use(&$params) {
				return $params[$x[1]];
			}

		, $this->path);

		echo $uri , PHP_EOL;
	}

	public function getId(){ return $this->id; }

	public function getPath(){ return $this->path; }

	public function getCmd(){ return $this->cmd; }
}