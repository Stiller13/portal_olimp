<?php
/**
 * Класс, представляющий запрос пользователя
 * 
 * Всем, кто читает данное пособие -- M. Zandstra - PHP Object, Patterns and Practice [p. 242]:
 *    "The Request object is _ALSO_ a useful repository for data that needs to be communicated to the view 
 *     layer. In that respect, Request can also provide response capabilities."
 * 
 *    "Объект Request ТАКЖЕ имеет дополнительное хранилище для данных, которые будут переданы в слой представления [...]"
 * 
 * _Данный_ класс НЕ предоставляет удобного местечка для хранения данных (см. определение слова _request_), которые будут переданы в
 * представление, так как это НЕ учебная демонстрация шаблонов.
 * 
 * Данный класс -- только для удобного доступа к тому, _ЧТО_ пользователь (браузер) запрашивает и _КАК_ запрашивает
 *
 * @see http://en.wikipedia.org/wiki/Hypertext_Transfer_Protocol		
 * @author nekjine
*/
namespace System\Network;

class Request implements \ArrayAccess {
	/**
	* Параметры запроса
	* @var array
	**/
	protected $data;

	/**
	* Строка запроса (/messages)
	* @var string
	**/
	protected $uri;

	// /**
	// * @var string
	// **/
	// protected $subject;

	/**
	* Метод запроса
	* @var int
	**/
	protected $method;

	/**
	* Конструктор
	**/
	function __construct(){
		$this->init();
	}

	/**
	* Самоинициализация Запроса в текущем окружении
	* @return void
	**/
	protected function init(){
		$this->method = strtolower($_SERVER["REQUEST_METHOD"]);
		$this->uri = $_SERVER["REQUEST_URI"];
		$this->data = $_REQUEST;
	}

	/**
	* Получает строку запроса
	* @return string Строка запроса
	**/
	public function getCleanURI(){
		$qm = strpos($this->uri, "?");
		if($qm === false){
			return $this->uri;
		}
		return substr($this->uri, 0, $qm);
	}

	public function getFullURI(){
		return $this->uri;
	}

	/**
	* Получает метод запроса
	* @return string Метод запроса
	**/
	public function getMethod(){
		return $this->method;
	}

	/**
	* Акцессоры для доступа к переменным http запроса
	* Реализация интерфейса ArrayAccess
	**/

	public function offsetSet($offset, $value){
		$this->data[$offset] = $value;
	}

	public function offsetGet($offset){
		if(!isset($this->data[$offset])){
			return null;
		}
		return $this->data[$offset];
	}

	public function offsetExists($offset){
		return isset($this->data[$offset]);
	}

	public function offsetUnset($offset){
		unset($this->data[$offset]);
	}
}