<?php

namespace Application\Orm;

class PUserDomainObjectFactory extends \System\Orm\DomainObjectFactory{

	public function doCreateObject(array $array) {
		$obj = new \Application\Model\PUser();

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
		$obj->setPost($array['post_user_post']);
		$obj->setRule(\System\Helper\Helper::getName("rule", $array['post_user_rule']));
		$obj->setRatio($array['post_user_ratio']);

		return $obj;
	}

	public function targetClass(){
		return "PUser";
	}
}
?>