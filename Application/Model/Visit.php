<?php

namespace Application\Model;

/**
 * Класс содержащий информацию о последнемм посещении пользователей группы
 * @author Zalutskii
 * @version 19.12.13
 */

class Visit extends \System\Orm\DomainObject {
	/**
	 * Список id пользователей
	 * @var array
	 */
	private $user_id;

	/**
	 * id группы
	 * @var integer
	 */
	private $mg_id;

	/**
	 * Дата последнего посещения
	 * @var date
	 */
	private $date_time;

	/**
	 * Количество непрочитанных сообщений
	 * @var integer
	 */
	private $count_message;

	public function setUserId($user_id) {
		$this->user_id = $user_id;
		$this->markDirty();
	}

	public function getUserId() {
		return $this->user_id;
	}

	public function setMessageGroupId($mg_id) {
		$this->mg_id = $mg_id;
		$this->markDirty();
	}

	public function getMessageGroupId() {
		return $this->mg_id;
	}

	public function setDate($date) {
		$this->date_time = $date;
		$this->markDirty();
	}

	public function getDate() {
		return $this->date_time;
	}

	public function setCountMessage($count) {
		 $this->count_message = $count;
		 $this->markDirty();
	}

	public function getCountMessage() {
		return $this->count_message;
	}

	public function targetClass() {
		return 'Visit';
	}

}

?>