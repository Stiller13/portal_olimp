<?php

namespace Application\Orm;

class PersonalMessageGroupUpdateFactory extends \System\Orm\UpdateFactory {

	public function newUpdate(\System\Orm\DomainObject $obj) {

		if ($obj->getId() >-1) {
			$values["status_mg"] = $obj->getStatus();
			$values['id_mg']=$obj->getId();

			return $this->buildStatement('update_messagegroup', $values);
		}

		$values["type_mg"] = \System\Helper\Helper::getId("type", "personal");
		$values["status_mg"] = $obj->getStatus();

		return $this->buildStatement('insert_messagegroup', $values, 1);
	}
}

?>