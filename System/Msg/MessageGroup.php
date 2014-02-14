<?php

namespace System\Msg;

/**
 * @author Zalutskii
 * @version 23.12.13
 * Абстрактный класс группы сообщений
 */

abstract class MessageGroup extends \System\Orm\DomainObject {
<<<<<<< HEAD
    /**
     * Заголовок группы
     * @var string
     */
    private $title;

    /**
     * Описание группы
     * @var string
     */
    private $description;

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
     * Задать заголовок группы
     * @param string $title
     */
    public function setTitle($title) {
        $this->title = $title;
        $this->markDirty();
    }

    /**
     * Получить заголовок группы
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Задать описание группы
     * @param $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * Получить описание группы
     */
    public function getDescription() {
        return $this->description;
    }

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
        if (!isset($this->messages)) {
            $this->messages = $this->getCollection($this->targetClass(), $this->getId());
        }
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
=======
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
	 * id группы пользователей
	 * @var integer
	 */
	private $userset;

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
	 * Установить id группы пользователей
	 */
	public function setUserset($id) {
		$this->userset = $id;
		$this->markDirty();
	}

	/**
	 * Получить id группы пользователей
	 * @return integer
	 */
	public function getUserset() {
		return $this->userset;
	}

	/**
	 * Тип группы в БД
	 */
	abstract function getTypeId();

	public function targetClass() {
		return 'MessageGroup';
	}
>>>>>>> 89eb8bd191a9046ada292c7cdab679b5164d3513
}

?>