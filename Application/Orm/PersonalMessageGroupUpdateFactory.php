<?php

namespace Application\Orm;

class PersonalMessageGroupUpdateFactory extends \System\Orm\UpdateFactory {

	public function newUpdate(\System\Orm\DomainObject $obj) {

		if ($obj->getId() >-1) {
			$values["message_group_status"] = $obj->getStatus();
			$values["message_group_partners"] = $partners_str;
			$values['message_group_id']=$obj->getId();
			return $this->buildStatement('update_messageset', $values);
		}

		$values["type_mg"] = $obj->getTypeId();
		$values["status_mg"] = $obj->getStatus();

		return $this->buildStatement('insert_messagegroup', $values, 1);
	}
}

?>