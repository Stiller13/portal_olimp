<?php

namespace Application\Model;

class EUser extends \Application\Model\User{

	private $rule;

	private $file;

	private $event;

	public function setRule($rule) {
		$this->rule = $rule;
		$this->markDirty();
	}

	public function getRule() {
		return $this->rule;
	}

	public function setFile($file) { 
		$this->file = $file;
		$this->markDirty();
	}

	public function getFile() {
		return $this->file;
	}

	public function setEvent($event) {
		$this->event = $event;
		$this->markDirty();
	}

	public function getEvent() {
		return $this->event;
	}

	public function targetClass() {
		return 'EUser';
	}
}
?>