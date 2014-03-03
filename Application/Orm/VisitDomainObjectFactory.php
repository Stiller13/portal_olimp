<?php

namespace Application\Orm;

class VisitDomainObjectFactory extends \System\Orm\DomainObjectFactory {

	public function doCreateObject(array $array) {
		$obj = new \Application\Model\Visit();
		$obj->setUserId($array["user_id"]);
		$obj->setMessageGroupId($array["group_id"]);
		$obj->setDate($array["datetime"]);
		$obj->setCountMessage($array["count_message"]);

		return $obj;
	}

	public  function targetClass() {
		return "Visit";
	}
}

?>