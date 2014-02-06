<?php

namespace Application\Orm;

class UserUpdateFactory extends \System\Orm\UpdateFactory{

	function newUpdate(DomainObject $obj) {
		$id = $obj->getId();
		$values['name']=$obj->getName();
		$values['family']=$obj->getFamily();
		$values['patronymic']= $obj->getPatronymic();
		$values['birthday']=$obj->getBirthday();
		$values['residence']=$obj->getResidence();
		$values['gender']=$obj->getGender();
		$values['id']=$obj->getId();

		return $this->buildStatement('update_user',$values);
	}
}

?>
