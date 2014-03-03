<?php

namespace Application\Orm;

class MGUserDomainObjectFactory extends \System\Orm\DomainObjectFactory{

	public function doCreateObject(array $array) {
		$obj = new \Application\Model\MGUser();

		$obj->setId($array['user_id']);
		$obj->setName($array['user_name']);
		$obj->setFamily($array['user_surname']);
		$obj->setPatronymic($array['user_patronymic']);
		$obj->setBirthday($array['user_date']);
		$obj->setResidence($array['user_residence']);
		$obj->setGender($array['user_gender']);
		$obj->setStatusSys($array['user_status']);
		$obj->setMail($array['user_mail']);
		$obj->setTelephone($array['user_telephone']);
		$obj->setGroup($array['messagegroup_user_group']);
		$obj->setRule(\System\Helper\Helper::getName("rule", $array['messagegroup_user_rule']));

		return $obj;
	}

	public function targetClass(){
		return "MGUser";
	}
}
?>