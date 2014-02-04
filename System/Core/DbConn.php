<?php
namespace System\Core;

/**
* "Менеджер" подключения к БД
* Все кто хочет себе ПДО должны попросить у этого класса
* Используется (пока) вместо тупого создания подключения где-то на старте системы
*/
class DbConn {
	/**
	* Константы, с которыми можно сравнивать результат функции ::getStatus()
	**/
	const CON_NOT_SET = -1;
	const CON_AVAILABLE = 0;
	const CON_CLOSED = 1;
	/**
	* Объект класса PDO
	**/
	private static $pdo;
	/**
	* @var int Статус подключения (-1: ещё не инициализировалось/недоступно, 0: успешно подключено, 1: закрыто)
	*/
	private static $status = self::CON_NOT_SET;

	private function __construct(){}
	/**
	* Получение объекта PDO
	* @return PDO
	**/
	public static function getPDO(){
		if(self::getStatus() == -1){
			self::openPDO();
		}
		return self::$pdo;
	}
	/**
	* Создание экземпляра объекта PDO
	* @return void
	**/
	private static function openPDO(){
		/**
		* Получаем данные для подключения из текущего Application (если доступны)
		*/
		$app = \System\Core\Application::instance();

		$db_data = $app->getData("db");
		$pdo_host = (string) $db_data["host"];
		$pdo_user = (string) $db_data["user"];
		$pdo_pass = (string) $db_data["pass"];
		$pdo_dbname = (string) $db_data["dbname"];

		try{
			self::$pdo = new \PDO("mysql:host=${pdo_host};dbname=${pdo_dbname}", $pdo_user, $pdo_pass, array(
				\PDO::ATTR_PERSISTENT => true
			));
		}catch(\PDOException $e){
			trigger_error("Unable to connect to the database");
		}
		self::setStatus(self::CON_AVAILABLE);
		// $app->set("pdo", $pdo);
	}
	/**
	* "Закрытие" PDO
	* @return void
	**/
	public static function closePDO(){
		self::$pdo = null;
		self::setStatus(self::CON_CLOSED);
	}
	/**
	* Получение статуса подключения
	* @return int
	*/
	public static function getStatus(){
		return self::$status;
	}
	/**
	* Установление статуса подключения
	* @param int $newStatus
	* @return void
	**/
	private static function setStatus($newStatus){
		self::$status = $newStatus;
	}
}