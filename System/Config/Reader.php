<?php
namespace System\Config;

use \Exception;

abstract class Reader {
	public function readFromFile($fileName){
		$path = $fileName;
		if(!is_readable($path)){
			throw new Exception("Could not find config file: $path");
		}
		return $this->_readFromFile($fileName);
	}

	abstract protected function _readFromFile($fileName);
}