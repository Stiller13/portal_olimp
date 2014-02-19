<?php

namespace Application\Model;

class User extends \System\Orm\DomainObject{
	private $name;

	private $family;

	private $patronymic;

	private $birthday;

	private $residence;

	private $gender;

	private $mail;

	private $telephone;

	private $status_system;

	private $role_in_group;

	function setName($name) {
		$this->name = $name;
		$this->markDirty();
	}

	function getName($letter = null) {
		if ($letter != null && $letter > -1 && $letter < strlen($this->name))
			return $this->name[$letter];
		else
			return $this->name;
	}

	function setFamily($family) { 
		$this->family = $family;
		$this->markDirty();

	}

	function getFamily() {
		return $this->family;
	}

	function setPatronymic($patronymic) {
		$this->patronymic = $patronymic;
		$this->markDirty();

	}
	function getPatronymic() {
		return $this->patronymic;
	}

	function setBirthday($birthday) { 
		$this->birthday = $birthday;
		$this->markDirty();

	}
	function getBirthday() {
		return $this->birthday;
	}

	function setResidence($residence) {
		$this->residence = $residence;
		$this->markDirty();
	}

	function getResidence() {
		return $this->residence;
	}

	function setGender($gender) {
		$this->gender = $gender;
		$this->markDirty();
	}

	function getGender() {
		return $this->gender;
	}

	function setMail($mail) {
		$this->mail = $mail;
		$this->markDirty();
	}

	function getMail() {
		return $this->mail;
	}

	function setTelephone($telephone) {
		$this->telephone = $telephone;
		$this->markDirty();
	}

	function getTelephone() {
		return $this->telephone;
	}

	function setRoleInGroup($role) {
		$this->role_in_group = $role;
		$this->markDirty();
	}

	function getRoleInGroup() {
		return $this->role_in_group;
	}

	function setStatusSys($new_status) {
		$this->status_system = $new_status;
		$this->markDirty();
	}

	function getStatusSys() {
		return $this->status_system;
	}

	function targetClass() {
		return 'User';
	}
}
?>