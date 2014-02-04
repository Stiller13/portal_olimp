<?php

namespace Application\Orm;

class AccountDomainObjectFactory extends \System\Orm\DomainObjectFactory{
    function doCreateObject(array $array){
        $obj= new \Application\Model\Account();
	$obj->setLogin($array['authorization_login']);       
	$obj->setPass($array['authorization_password']); 
	$obj->setSalt($array['authorization_salt']); 
	$obj->setId($array['user_id']);  	
	return $obj;
    }
    
    function targetClass(){
        return "Account";
    }
}
?>
