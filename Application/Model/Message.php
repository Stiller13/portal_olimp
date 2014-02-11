<?php

namespace Application\Model;

/**
* @author Zalutskii
* @version 10.02.14
* Класс сообщения
*/

class Message extends \System\Orm\DomainObject {

	/**
	 * Автор сообщения
	 * @var Application\Model\User
	 */
	private $author;

	/**
	 * Текст сообщения
	 * @var string
	 */
	private $text;

	/**
	 * Прикрепленные файлы
	 */
	private $files;
	/**
	 * Группа сообщений
	 * @var integer
	 */
	private $group;

	/**
	 * Дата отправки сообщения
	 * @var date
	 */
	private $date;

	/**
	 * Статус сообщения
	 * @var int
	 */
	private $status;

	/**
	 * Ответы
	 * @var MessageCollection
	 */
	private $messages;

	/**
	 * Отвечаемое сообщение
	 * @var integer
	 */
	private $remessage;

	/**
	 * Задать автора
	 * @param \Application\Model\User $author
	 */
	public function setAuthor($author) {
		$this->author = $author;
		$this->markDirty();
	}

	/**
	 * Получить автора
	 * @return \Application\Model\User
	 */
	public function getAuthor() {
		return $this->author;
	}

	/**
	 * Задать текст сообщения
	 * @param unknown $text
	 */
	public function setText($text) {
		$this->text = $text;
		$this->markDirty();
	}

	/**
	 * Получить текст сообщения
	 */
	public function getText() {
		return $this->text;
	}

	/**
	 * Задать id группы сообщений
	 */
	public function setGroup($group_id) {
		$this->group = $group_id;
		$this->markDirty();
	}

	/**
	 * Получить id группы сообщений
	 * @return integer
	 */
	public function getGroup() {
		return $this->group;
	}

	/**
	 * Задать коллекцию файлов
	 * @param Application\Orm\FileCollection $files 
	 */
	public function setFiles(\Application\Orm\FileCollection $files) {
		$this->files = $files;
		$this->markDirty();
	}

	/**
	 * Получить коллекцию файлов
	 * @return Application\Orm\FileCollection
	 */
	public function getFiles() {
		if (!isset($this->files)) {
			$this->files = $this->getCollection($this->targetClass(), $this->getId());
		}
		return $this->files;
	}

	/**
	 * Добавить файл
	 * @todo Со временем уберется
	 */
	public function addFile($file) {
		$this->getFiles()->add($file);
		$this->markDirty();
	}

	/**
	 * Установить дату отправки сообщения
	 * @param unknown $date
	 */
	public function setDate($date) {
		$this->date = $date;
		$this->markDirty();
	}

	/**
	 * Получить дату отправки сообщения
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * Установить статус сообщения
	 * @param int $status
	 */
	public function setStatus($status) {
		$this->status = $status;
		$this->markDirty();
	}

	/**
	 * Получить статус сообщения
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * Задать коллекцию ответов
	 * @param Application\Orm\MessageCollection $mes 
	 */
	public function setMessages(\Application\Orm\MessageCollection $mes) {
		$this->messages = $mes;
		$this->markDirty();
	}

	/**
	 * Получить коллекцию ответов
	 * @return Application\Orm\MessageCollection
	 */
	public function getMessages() {
		if (!isset($this->messages)) {
			$this->messages = $this->getCollection($this->targetClass(), $this->getId());
		}
		return $this->messages;
	}

	/**
	 * Добавить ответ
	 */
	public function addMessage($mes) {
		$this->getMessages()->add($mes);
		$this->markDirty();
	}

	/**
	 * Установить твечаемое сообщение
	 * @param integer $id
	 */
	public function setReMessage($id) {
		$this->remessage = $id;
		$this->markDirty();
	}

	/**
	 * Получить отвечаемое сообщение
	 */
	public function getReMessage() {
		return $this->remessage;
	}

	public function targetClass() {
		return 'Message';
	}
}

?>