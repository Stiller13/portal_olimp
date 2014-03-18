<?php
namespace System\Log;

class Logger {
	private static $file_path;
	private static $file;
	const DATE_FORMAT = "d.m.Y H:i:s";

	private function __construct(){}
	/**
	* Инициализация (вызывается явно)
	**/
	public static function init($file_path){
		self::$file_path = $file_path;
		$file = fopen($file_path, "a");
		if($file === false){
			trigger_error("Log file cannot be opened or created");
			exit;
		}
		self::$file = $file;
	}
	/**
	* Прямая запись строки в журнал
	*/
	public static function raw_log($str){
		fwrite(self::$file, $str);
	}
	/**
	* Детальная запись в журнал
	*/
	public static function log($str){
		self::raw_log(date(self::DATE_FORMAT));
		self::raw_log(" ");
		self::raw_log($_SERVER["REQUEST_METHOD"]);
		self::raw_log(" ");
		self::raw_log($_SERVER["REQUEST_URI"]);
		// self::raw_log(" ");
		// self::raw_log($_SERVER["REMOTE_ADDR"]);
		// self::raw_log(" ");
		// self::raw_log($_SERVER["HTTP_USER_AGENT"]);
		self::raw_log(" - ");
		self::raw_log($str);
		self::raw_log(PHP_EOL);
	}
}