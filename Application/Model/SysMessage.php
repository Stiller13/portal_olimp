<?php

namespace Application\Model;

/**
* @author Zalutskii
* @version 05.02.14
* Класс системного сообщения
*/

class SysMessage extends \Application\Model\Message {

	/**
	 * Дата начала показа
	 * @var start_show
	 */
	private $start_show;

	/**
	 * Дата окончания показа
	 * @var stop_show
	 */
	private $stop_show;

	/**
	 * Установить дату начала показа сообщения
	 * @param date $date
	 */
	public function setStartShow($date) {
		$this->start_show = $date;
		$this->markDirty();
	}

	/**
	 * Получить дату начала показа сообщения
	 */
	public function getStartShow() {
		return $this->start_show;
	}

	/**
	 * Установить дату конца показа сообщения
	 * @param date $date
	 */
	public function setStopShow($date) {
		$this->stop_show = $date;
		$this->markDirty();
	}

	/**
	 * Получить дату конца показа сообщения
	 */
	public function getStopShow() {
		return $this->stop_show;
	}

	public function targetClass() {
		return 'SysMessage';
	}
}

?>