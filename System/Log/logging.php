<?php
use \System\Log\Logger as Logger;

if(MODE == "debug"){
	require __DIR__.DS."Logger.php";

	Logger::init(TMP.DS.LOGFILE);
	/**
	* Подробная запись в журнал
	**/
	function xlog($str){
		Logger::log($str);
	}
	/**
	* Запись в журнал результата функции var_dump($mixed)
	**/
	function xdump($mixed){
		ob_start();
		var_dump($mixed);
		$str = ob_get_clean();
		xlog($str);
	}

}else{
	function xlog(){}
	function xdump(){}
}