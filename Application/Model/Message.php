<?php

namespace Application\Model;

/**
* @author Zalutskii
* @version 31.01.14
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
	private $group_id;

	/**
	 * Дата отправки сообщения
	 * @var date
	 */
	private $date;

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
		$this->group_id = $group_id;
		$this->markDirty();
	}

	/**
	 * Получить id группы сообщений
	 * @return integer
	 */
	public function getGroup() {
		return $this->group_id;
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

	public function targetClass() {
		return 'Message';
	}
}

?>