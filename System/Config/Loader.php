<?php
namespace System\Config;

/**
* Загрузчик конфигурационных файлов, требуется указать только директорию с .xml файлами
* Поддерживается переопределение конфигурационных данных
*/
class Loader {
	private $path;

	/**
	* Конструктор
	* @param string $path Директория для загрузки конфигурационных файлов
	*/
	public function __construct($path){
		$this->path = $path;
	}

	/**
	* Получает расширение файла по имени
	* @return string Расширение
	*/
	private function _GetExtension($path){
		$dot_pos = strrpos($path, '.');
		if($dot_pos === false){
			return null;
		}else{
			return substr($path, $dot_pos + 1);
		}
	}

	/**
	* Загружает файлы из директории
	* @return array Собранный конфиг, в виде массива из SimpleXMLElement'ов
	*/
	public function Load(){
		$dh = opendir($this->path);
		if($dh === false){
			trigger_error("Failed to opendir()");
			return false;
		}
		$result = array();
		$overrides = array();

		while(false !== ($f = readdir($dh))){

			$format = $this->_GetExtension($f);
			if($format != "xml"){
				continue;
			}
			$xml = new \System\Config\Reader\XML;
			$xml_res = $xml->readFromFile($this->path . DS . $f);
			foreach($xml_res->children() as $child){
				$scope_name = $child->getName();
				$override = $child["override"] != null;
				if(isset($result[$scope_name])){
					if($overrides[$scope_name] == false && $override == true){
						$result[$scope_name] = $child;
					}
				}else{
					$result[$scope_name] = $child;
					$overrides[$scope_name] = $override;
				}
			}

		}

		return $result;
	}
}
