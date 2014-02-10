<?php

namespace Application\Orm;

class AccountUpdateFactory extends \System\Orm\UpdateFactory{

	function newUpdate(\System\Orm\DomainObject $obj) {
		$values["login"]=$obj->getLogin();
		$values["password"]=$obj->getPass();
		$values["salt"]=$obj->getSalt();
		
		if($obj->getId() > -1){
			return $this->buildStatement('update_account',$values);
		}

		return $this->buildStatement('insert_account',$values, 1);
	}
}
?>
