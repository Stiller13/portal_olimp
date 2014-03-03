<?php

namespace Application\Model;

class Event extends \System\Orm\DomainObject{

	private $title;
	private $description_public;
	private $description_private;
	private $event_type;
	private $confirm;           //требуется ли подтверждение
	private $confirm_description; //описание этого подтверждения
	private $partners;
	private $comment_group;
	private $notice_groups; 		// как таковой пока нет, но обязательно появится
	private $files;


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

	public function targetClass() {
		return 'Event';
	}

}
 
