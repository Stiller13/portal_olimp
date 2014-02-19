<?php

namespace Application\Orm;

class UserUpdateFactory extends \System\Orm\UpdateFactory{

	public function newUpdate(\System\Orm\DomainObject $obj) {
		$values['name']=$obj->getName();
		$values['surname']=$obj->getFamily();
		$values['patronymic']= $obj->getPatronymic();
		$values['birthday']=$obj->getBirthday();
		$values['residence']=$obj->getResidence();
		$values['gender']=$obj->getGender();
		$values['mail']=$obj->getMail();
		$values['telephone']=$obj->getTelephone();
		$values['status']=$obj->getStatusSys();
		$values['id']=$obj->getId();

		return $this->buildStatement('update_user',$values);
	}
}

?>
