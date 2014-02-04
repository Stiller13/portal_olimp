<?php

namespace Application\Orm;

class UserRoleDomainObjectFactory extends \System\Orm\DomainObjectFactory{
    function doCreateObject(array $array){
        $obj= new \Application\Model\UserRole();
	$obj->setUser_id($array['user_id']); 
	$obj->setRole($array['role']);
        return $obj;
    }
    
    function targetClass(){
        return "UserRole";
    }
}
