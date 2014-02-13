<?php

namespace Application\Orm;

class RuleObjDomainObjectFactory extends \System\Orm\DomainObjectFactory{

	public function doCreateObject(array $array) {
		$obj= new \Application\Model\RuleObj();

		$obj->setObj_id($array['obj_id']);
		$obj->setUser_id($array['user_id']);
		$obj->setRule($array['rule_id']);
		$obj->setObj_type($array['obj_type']);
		$obj->setUserset_id($array['userset_id']);

		return $obj;
	}

	public  function targetClass(){
		return "RuleObj";
	}
}
?>
