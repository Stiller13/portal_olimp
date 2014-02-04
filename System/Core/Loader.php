<?php
namespace System\Core;

class Loader {
	private static function autoload($class_ns_path){
		$path = ROOT .DS. str_replace("\\", DS, $class_ns_path) .".php";
		if(!is_readable($path)){
			//trigger_error("Class file {$path} for ${class_ns_path} does not exist or not readable", E_USER_WARNING);
			return false;
			
		}
		require_once($path);
		if(!class_exists($class_ns_path)){
			//trigger_error("Class ${class_ns_path} not found in the file where it should be", E_USER_ERROR);
			return false;
		}
	}

	public static function init(){
		spl_autoload_register("System\\Core\\Loader::autoload");
	}
}

Loader::init();