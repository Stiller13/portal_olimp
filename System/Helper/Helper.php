<?php
namespace System\Helper;
use System\Core\Application;

class Helper {
	static private $helper=array();
	
	static public function getName($conf_type, $id){
		$app = Application::instance();
		$config = $app->getData("map");
		if (!isset(self::$helper[$conf_type])) {
			self::parse($conf_type);
		}
		return (string)self::$helper[$conf_type][(string)$id];
	}

	static public function getId($conf_type, $name){
		$app = Application::instance();
		$config = $app->getData("map");
		if (!isset(self::$helper[$conf_type])) {
			self::parse($conf_type);
		}
		if (array_search($name, self::$helper[$conf_type])){
			return (string)array_search($name, self::$helper[$conf_type]);
		}
		return NULL;
	}

	static private function parse($conf_type){
		$app = Application::instance();
		$config = $app->getData("map");
		foreach ($config->$conf_type as $p){
			self::$helper[$conf_type][(string)$p["id"]] = $p["name"];	
		}
	}	
}
