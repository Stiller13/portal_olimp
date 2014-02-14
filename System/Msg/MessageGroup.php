<?php

namespace System\Msg;

/**
 * @author Zalutskii
 * @version 10.02.13
 * Абстрактный класс группы сообщений
 */

abstract class MessageGroup extends \System\Orm\DomainObject {
	/**
	 * Участники группы
	 * @var UserCollection
	 */
	private $partners;

	/**
	 * Сообщения группы
	 * @var \Application\Model\Message
	 */
	private $messages;

	/**
	 * Статус
	 * @var integer
	 */
	private $status;

	/**
	 * Установить участников группы
	 * @param Application\Orm\AccountCollection $partners
	 */

	public function setPartners(\Application\Orm\UserCollection $partners) {
		$this->partners = $partners;
		$this->markDirty();
	}
	/**
	 * Получить участников группы
	 * @return \Application\Model\Account
	 */

	public function getPartners() {
		if (!isset($this->partners)) {
			$this->partners = $this->getCollection($this->targetClass(), $this->getId());
		}
		return $this->partners;
	}

	/**
	 * Задать список сообщений
	 * @param Application\Orm\MessageCollection $messages
	 */
	public function setMessages(\Application\Orm\MessageCollection $messages) {
		$this->messages = $messages;
		$this->markDirty();
	}

	/**
	 * Получить сообщения
	 * @return \Application\Orm\MessageCollection
	 */
	public function getMessages() {
		// if (!isset($this->messages)) {
		// 	$this->messages = $this->getCollection($this->targetClass(), $this->getId());
		// }
		return $this->messages;
	}

	/**
	 * Вставка сообщения
	 * @param Application\Model\Message $new_message
	 */
	public function addMessage(\Application\Model\Message $new_message) {
		$this->getMessages()->add($new_message);
		$this->markDirty();
	}

	/**
	 * Установить статус группы
	 */
	public function setStatus($new_status) {
		$this->status = $new_status;
		$this->markDirty();
	}

	/**
	 * Получить статус группы
	 * @return integer
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * Тип группы в БД
	 */
	abstract function getTypeId();

	public function targetClass() {
		return 'MessageGroup';
	}
}

?>