<?php

namespace Application\Orm;

class CommentMessageGroupUpdateFactory extends \System\Orm\UpdateFactory {

	public function newUpdate(\System\Orm\DomainObject $obj) {

		$values['message_group_title'] = $obj->getTitle();
		$values['message_group_description'] = $obj->getDescription();

		if ($obj->getId() >-1) {
			$values["message_group_status"] = $obj->getStatus();
			$values["message_group_partners"] = "";
			$values['message_group_id']=$obj->getId();
			return $this->buildStatement('update_messageset', $values);
		}

		$values["message_group_type"] = $obj->getTypeId();
		$values["message_group_status"] = $obj->getStatus();
		$values["message_group_partners"] = "";

		return $this->buildStatement('create_messageset', $values, 1);
	}
}

?>