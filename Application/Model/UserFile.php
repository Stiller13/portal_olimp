<?php

namespace Application\Model;

/**
 * Класс сввязки пользователь-файл
 * @author Zalutskii
 * @version 01.03.14
 */

class UserFile extends \System\Orm\DomainObject {
	/**
	* id пользователя
	*/
	private $user_id;

	/**
	* id файла
	*/
	private $file_id;

	/**
	* Задать id пользователя
	*/
	public function setUser($id) {
		$this->user_id = $id;
		$this->markDirty();
	}

	/**
	* Полуить id пользователя
	*/
	public function getUser() {
		return $this->user_id;
	}

	/**
	* Задать id файла
	*/
	public function setFile($id) {
		$this->file_id = $id;
		$this->markDirty();
	}

	/**
	* Полуить id файла
	*/
	public function getFile() {
		return $this->file_id;
	}

	public function targetClass() {
		return 'UserFile';
	}
}

?>