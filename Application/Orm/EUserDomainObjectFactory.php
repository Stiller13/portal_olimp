<?php

namespace Application\Orm;

class EUserDomainObjectFactory extends \System\Orm\DomainObjectFactory{

	public function doCreateObject(array $array) {
		$obj = new \Application\Model\EUser();

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
		$obj->setEvent($array['event_user_event']);
		$obj->setRule(\System\Helper\Helper::getName("rule", $array['event_user_rule']));
		$obj->setFile($this->createFile($array['event_user_file']));

		return $obj;
	}

	public function createFile($id_file) {
		$factory = \System\Orm\PersistenceFactory::getFactory('File');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->field('file_id')->eq($id_file);

		return $finder->findOne($idobj,'file');
	}

	public function targetClass(){
		return "EUser";
	}
}
?>