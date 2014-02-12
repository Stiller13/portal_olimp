<?php

namespace Application\Orm;

class VisitDomainObjectFactory extends \System\Orm\DomainObjectFactory {

	public function doCreateObject(array $array) {
		$obj = new \Application\Model\Visit();
		$obj->setId($array['visit_id']);
		$obj->setUserId($array['visit_user']);
		$obj->setMessageGroupId($array['visit_group']);
		$obj->setDate($array['visit_datetime']);
		$obj->setCountMessage($array['visit_count_message']);

		return $obj;
	}

	public  function targetClass() {
		return "Visit";
	}
}

?>