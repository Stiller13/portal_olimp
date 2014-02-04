<?php
namespace System\Session;
/**
* Класс для работы с сессией
**/
class Session  {
	/**
	* Конструктор
	* @param string $namespace Пространство имён (в нашем случае просто префикс) всех переменных данной сессиии
	**/
	public function __construct(){
		if(!isset($_SESSION)){
			session_start();
		}
	}

	/**
	* Устанавливает значение переменной сессии
	* @param string $key Имя переменной
	* @param string $value Новое значение переменной
	**/
	public function set($key, $value){
		$_SESSION[$key] = $value;
	}

	/**
	* Возвращает значение переменной сессии
	* @param string $key Имя переменной
	* @return string Значение переменной
	**/
	public function get($key){
		if(!isset($_SESSION[$key])){
			return null;
		}
		return $_SESSION[$key];
	}
}