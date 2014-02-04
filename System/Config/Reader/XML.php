<?php
namespace System\Config\Reader;

use \System\Config\Reader as AbstractReader;
use \XMLReader;

class XML extends AbstractReader {
	protected function _readFromFile($fileName){
		return simplexml_load_file($fileName);
	}
}