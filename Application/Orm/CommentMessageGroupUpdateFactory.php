<?php

namespace Application\Orm;

class CommentMessageGroupUpdateFactory extends \System\Orm\UpdateFactory {

	public function newUpdate(\System\Orm\DomainObject $obj) {

		$values["desc_mg"] = $obj->getDescription();

		if ($obj->getId() >-1) {
			$values["status_mg"] = $obj->getStatus();
			$values['id_mg']=$obj->getId();

			return $this->buildStatement('update_messagegroup', $values);
		}

		$values["type_mg"] = \System\Helper\Helper::getId("type", "comment");
		$values["status_mg"] = $obj->getStatus();

		return $this->buildStatement('insert_messagegroup', $values, 1);
	}
}

?>