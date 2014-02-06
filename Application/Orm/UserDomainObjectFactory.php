<?php

namespace Application\Orm;

class UserDomainObjectFactory extends \System\Orm\DomainObjectFactory{

	function doCreateObject(array $array) {
		$obj = new \Application\Model\User();

		$obj->setId($array['user_id']);
		$obj->setName($array['user_name']);
		$obj->setFamily($array['user_surname']);
		$obj->setPatronymic($array['user_patronymic']);
		$obj->setBirthday($array['user_date']);
		$obj->setResidence($array['user_residence']);
		$obj->setGender($array['user_gender']);
		$obj->setRoleInGroup($array['user_userset_status_map_id']);

		return $obj;
	}

	function targetClass(){
		return "User";
	}
}
?>