<?php

namespace Application\Model;

/**
 * Класс файла
 * @author Zalutskii
 * @version 30.10.13
 */

class File extends \System\Orm\DomainObject {
	/**
	* Название файла
	* @var  string
	*/
	private $name;

	/**
	* Уникальный код файла
	* @var string
	*/
	private $code;

	/**
	 * Дата загрузки файла
	 * @var date
	 */
	private $date;

	/**
	 * Тип файла
	 * @var integer
	 */
	private $type;

	/**
	 * Статус файла
	 * @var integer
	 */
	private $status;

	/**
	* Задать имя файла
	*/
	public function setName($name) {
		$this->name = $name;
		$this->markDirty();
	}

	/**
	* Полуить имя файла
	*/
	public function getName() {
		return $this->name;
	}

	/**
	* Задать код файла
	*/
	public function setCode($code) {
		$this->code = $code;
		$this->markDirty();
	}

	/**
	* Полуить код файла
	*/
	public function getCode() {
		return $this->code;
	}

	/**
	 * Установить дату
	 * @param date $new_date
	 */
	public function setDate($date) {
		$this->date = $date;
		$this->markDirty();
	}

	/**
	 * Получить дату загрузки файла
	 * @return date
	 */
	public function getDate() {
		return $this->date;
	}

	public function setFile_type($new_type) {
		$this->type = $new_type;
		$this->markDirty();
	}

	public function getFile_type() {
		return $this->type;
	}

	public function setStatus($new_status) {
		$this->status = $new_status;
		$this->markDirty();
	}

	public function getStatus() {
		return $this->status;
	}

	public function targetClass() {
		return 'File';
	}
}

?>