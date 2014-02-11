<?php

namespace Application\Orm;

class StatusObjDomainObjectFactory extends \System\Orm\DomainObjectFactory{
    function doCreateObject(array $array){
        $obj= new \Application\Model\StatusObj();
	$obj->setObj_id($array['object_id']); 
	$obj->setObj_type($array['type_object_map_name']);
	$obj->setObj_status($array['status_map_name']);	
        return $obj;
    }
    
    function targetClass(){
        return "StatusObj";
    }
}
?>
