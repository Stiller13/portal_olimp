<?php

namespace Application\Model;

class MGUser extends \Application\Model\User{

	private $rule;

	private $group;

	private $time_update;

	public function setRule($rule) {
		$this->rule = $rule;
		$this->markDirty();
	}

	public function getRule() {
		return $this->rule;
	}

	public function setGroup($group) {
		$this->group = $group;
		$this->markDirty();
	}

	public function getGroup() {
		return $this->group;
	}

	public function setTimeUpdate() {
		$this->time_update = true;
	}

	public function getTimeUpdate() {
		return $this->time_update;
	}

	public function targetClass() {
		return 'MGUser';
	}
}
?>