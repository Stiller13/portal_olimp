<?php
namespace Application\Orm;

class RuleObjDomainObjectFactory extends \System\Orm\DomainObjectFactory{
    public function doCreateObject(array $array){
        $obj= new \Application\Model\RuleObj();
	$obj->setUser_id($array['user_id']);     
	$obj->setObj_id($array['object_id']);  
	$obj->setRule($array['rule']);  
	$obj->setObj_type($array['object_name']);  
        return $obj;
    }
       
    public  function targetClass(){
        return "RuleObj";
    }
}
?>
