<?php
define("DS", DIRECTORY_SEPARATOR);
define("ROOT", str_replace("/", DS, dirname($_SERVER["SCRIPT_FILENAME"])));
define("APP", ROOT.DS."Application");
define("TMP", APP.DS."Tmp");
define("SYS", ROOT.DS."System");
define("UPL", ROOT.DS.'Uploads'.DS);
/**
* Режим работы приложения
* Возможные значения: 
* 	"debug" : вывод отладочной информации
* 	любое другое : подавление всей отладочной информации
**/
define("MODE", "debug");
/**
* Имя файла журнала
* 	Относительный путь задаётся для директории APP.DS.TMP (напр. "mylog.txt")
* 	Абсолютный путь задаётся как есть для любой директории (напр. "/var/log/mylog.log")
**/
define("LOGFILE", "process.log");

require SYS.DS."Log".DS."logging.php";
xlog("Application start");
require SYS.DS."Core".DS."Loader.php";

use System\Core\Dispatcher;
use System\Network\Request;
use System\Network\Response;

$dispatcher = new Dispatcher(new Request, new Response);
$dispatcher->dispatch();

function sd(){
	xlog("Application finish");
}
register_shutdown_function("sd");
