<?php

namespace Application\Orm;

class VisitDomainObjectFactory extends \System\Orm\DomainObjectFactory {

	public function doCreateObject(array $array) {
		$obj = new \Application\Model\Visit();
		$obj->setId($array['visit_id']);
		$obj->setUserId($array['user_id']);
		$obj->setMessageGroupId($array['visit_message_group_id']);
		$obj->setDate($array['visit_datetime']);
		$obj->setCountMessage($array['visit_count_message']);

		return $obj;
	}

	public  function targetClass() {
		return "Visit";
	}
}

?>