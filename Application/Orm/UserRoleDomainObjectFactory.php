<?php

namespace Application\Orm;

class UserRoleDomainObjectFactory extends \System\Orm\DomainObjectFactory {

	function doCreateObject(array $array) {
		$obj = new \Application\Model\UserRole();

		$obj->setId($array['role_id']);
		$obj->setUser_id($array['role_user']); 
		$obj->setRole(\System\Helper\Helper::getName("role", $array['role_role']));

		return $obj;
	}

	function targetClass(){
		return "UserRole";
	}

}
