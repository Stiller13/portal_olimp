<?php

namespace Application\Orm;

class AccountDomainObjectFactory extends \System\Orm\DomainObjectFactory{

	function doCreateObject(array $array) {
		$obj= new \Application\Model\Account();

		$obj->setLogin($array['account_login']);
		$obj->setPass($array['account_password']);
		$obj->setSalt($array['account_salt']);
		$obj->setId($array['account_id']);

		return $obj;
	}

	function targetClass(){
		return "Account";
	}
}
?>
