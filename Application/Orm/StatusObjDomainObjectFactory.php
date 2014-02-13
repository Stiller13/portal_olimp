<?php

namespace Application\Orm;

class StatusObjDomainObjectFactory extends \System\Orm\DomainObjectFactory{
	function doCreateObject(array $array){
		$obj= new \Application\Model\StatusObj();

		$obj->setObj_id($array['obj_id']); 
		$obj->setObj_type($array['obj_type']);
		$obj->setObj_status($array['obj_status']);

		return $obj;
	}

	function targetClass(){
		return "StatusObj";
	}
}
?>
