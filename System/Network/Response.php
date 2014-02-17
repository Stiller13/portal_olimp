<?php
/**
 * Класс, представляющий окончательный ответ пользователю
 *
 * Всё, что отдаётся в ответ пользователю (Тело Ответа, Заголовки Ответа), регулируется здесь.
 * 
 * @see http://en.wikipedia.org/wiki/Hypertext_Transfer_Protocol		Если вы не знаете что такое тело и заголовки ответа
 * @author nekjine
 */
namespace System\Network;

class Response {
	/**
	* Были ли посланы заголовки http-ответа, если были, то дальнейший вывод невозможен
	* @var bool
	**/
	protected $headers_sent = false;

	/**
	* Конструктор (пустой)
	**/
	public function __construct(){}

	/**
	* Выводит финальный текст
	* @param string $str Текст для вывода
	* @return void
	**/
	public function write($str){
		header("Content-Type: text/html; charset=utf-8");

		if(!$this->headers_sent){
			echo $str;
			$this->headers_sent = true;
		}
	}

	/**
	* Отдает файл
	* @param string $str Текст для вывода
	* @return void
	**/
	public function get($fd, $ftime, $fsize, $file_outname){
		if (!$fd){
			header ("HTTP/1.0 403 Forbidden");
			exit;
		}

		if($HTTP_SERVER_VARS["HTTP_RANGE"]) {
			$range = $HTTP_SERVER_VARS["HTTP_RANGE"];
			$range = str_replace("bytes=", "", $range);
			$range = str_replace("-", "", $range);
			if ($range)
				fseek($fd, $range);
		}

		if($range) {
			header("HTTP/1.1 206 Partial Content");
		} else {
			header("HTTP/1.1 200 OK");
		}
		header("Content-Disposition: attachment; filename=$file_outname");
		header("Last-Modified: $ftime");
		header("Accept-Ranges: bytes");
		header("Content-Length: ".($fsize-$range));
		header("Content-Range: bytes $range-".($fsize - 1)."/".$fsize);
		header("Content-type: $mimetype");

		fpassthru($fd);
	}

	/**
	* Назначает статус http-ответа
	* @param int $statusCode Http-код ответа
	* @return void
	**/
	public function setStatus($statusCode){
		if(is_int($statusCode) || is_string($statusCode)){
			//$this->headers
			header(' ', true, $statusCode);
		}
	}

	/**
	* Перенаправляет на указанный url
	* @param string $url Целевой url
	* @param int $status Статус http-ответа
	* @return void
	**/
	public function setRedirection($url, $status = 301){
		if(is_string($url)){
			$this->setStatus($status);
			header("Location: ${url}");
			$this->headers_sent = true;
		}
	}

	/**
	* Устанавливает параметры кэширования
	* @param bool $to Кэшировать или нет
	* @return void
	**/
	public function setCaching($to=true){
		if(!$to){
			// cache off
			header("Cache-Control: no-cache, must-revalidate");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
		}else{
			// cache on
			header("Cache-Control:");
			header("Expires:");
		}
	}
}