<?php

namespace Application\Model;

class User extends \System\Orm\DomainObject{
	private $name;

	private $family;

	private $patronymic;

	private $birthday;

	private $residence;

	private $gender;

	private $role_in_group;

	function setName($name) {
		$this->name = $name;
		$this->markDirty();

	}
	function getName() {
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

	function setEducation($education) {
		$this->education = $education;
		$this->markDirty();
	}

	function getEducation() {
		return $this->education;
	}

	function setRoleInGroup($role) {
		$this->role_in_group = $role;
		$this->markDirty();
	}

	function getRoleInGroup() {
		return $this->role_in_group;
	}

	function targetClass() {
		return 'User';
	}
}
?>