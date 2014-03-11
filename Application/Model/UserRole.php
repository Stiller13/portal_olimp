<?php

namespace Application\Model;


class UserRole extends \System\Orm\DomainObject{

	private $user_id;
	private $role;

	public function setUser_id($u_id){
		$this->user_id = $u_id;
		$this->markDirty();
	}

	public function getUser_id(){
		return $this->user_id;
	}

	public function setRole($role_name){
		$this->role = $role_name;
		$this->markDirty();
	}

	public function getRole(){
		return $this->role;
	}

	public function targetClass(){
		return 'UserRole';
	}
}
