<?php

namespace Application\Model;

/**
 * Класс мероприятия
 * @author Zalutskii
 */

class Event extends \System\Orm\DomainObject{

/**
 * Название мероприятия
 * @var string 
 */
	private $title;

/**
 * Публичное описание мероприятия
 * @var string
 */
	private $description_public;

/**
 * Описание, доступное только участникам мероприятия
 * @var string
 */
	private $description_private;

/**
 * Тип мероприятия
 * @var string
 */
	private $event_type;

/**
 * Требуется ли документ при подаче заявки на участие
 * @var bool
 */
	private $confirm;

/**
 * Описание требуемого документа
 * @var string
 */
	private $confirm_description; //описание этого подтверждения

/**
 * Участники мероприятия
 * @var Application\Orm\EUserCollection
 */
	private $partners;

/**
 * Группа для комментариев
 * @var Application\Model\CommentMessageGroup
 */
	private $comment_group;

/**
 * Группы для оповещений участников
 * @var Application\Orm\NoticeMessageGroupCollection
 */
	private $notice_groups;

/**
 * Прикрепленные файлы
 * @var Application\Orm\FileCollection
 */
	private $files;

/**
 * Статутус мероприятия
 * @var string
 */
	private $status;

	public function setTitle($text) {
		$this->title = $text;
		$this->markDirty();
	}

	public function getTitle() {
		return $this->title;
	}

	public function setDescription_public($text) {
		$this->description_public = $text;
		$this->markDirty();
	}

	public function getDescription_public() {
		return $this->description_public;
	}

	public function setDescription_private($text) {
		$this->description_private = $text;
		$this->markDirty();
	}

	public function getDescription_private() {
		return $this->description_private;
	}

	public function setEvent_type($type) { //функция settype в php уже есть, так что не будем его гневить
		$this->type = $type;
		$this->markDirty();
	}

	public function getEvent_type() {
		return $this->type;
	}

	public function setConfirm($conf) {
		$this->confirm = $conf;
		$this->markDirty();
	}

	public function getConfirm() {
		return $this->confirm;
	}

	public function setConfirm_description($text) {
		$this->confirm_description = $text;
		$this->markDirty();
	}

	public function getConfirm_description() {
		return $this->confirm_description;
	}

	public function setPartners(\Application\Orm\EUserCollection $partners) {
		$this->partners = $partners;
		$this->markDirty();
	}

	public function getPartners() {
		if (! isset($this->partners)) {
			$this->partners = $this->getCollection($this->targetClass(), $this->getId());
		}
		return $this->partners;
	}

	public function getComments() {
		return $this->comment_group;
	}

	public function setComments($mg) {
		$this->comment_group = $mg;
		$this->markDirty();
	}

	public function setNoticeGroups($mgs) {
		$this->notice_groups = $mgs;
		$this->markDirty();
	}

	public function getNoticeGroups() {
		if (!isset($this->notice_groups)) {
			$this->notice_groups = $this->getCollection($this->targetClass(), $this->getId());
		}

		return $this->notice_groups;
	}

	public function getNoticeGroup($status) {
		foreach ($this->getNoticeGroups() as $one_group) {
			if ($one_group->getStatus() === $status) {
				return $one_group;
			}
		}
		return null;
	}

	public function addNoticeGroup($mg) {
		$this->getNoticeGroups()->add($mg);
		$this->markDirty();
	}

	public function setFiles(\Application\Orm\FileCollection $list_file) {
		$this->files = $list_file;
		$this->markDirty();
	}

	public function getFiles() {
		if (!isset($this->files)) {
			$this->files = $this->getCollection($this->targetClass(), $this->getId());
		}

		return $this->files;
	}

	public function addFile(\Application\Model\File $file) {
		$this->files->add($file);
		$this->markDirty();
	}

	public function setStatus($new_status) {
		$this->status = $new_status;
		$this->markDirty();
	}

	public function getStatus() {
		return $this->status;
	}

	public function targetClass() {
		return 'Event';
	}

}
 
