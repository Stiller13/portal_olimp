<?php

namespace Application\Orm;

class VisitUpdateFactory extends \System\Orm\UpdateFactory {

	public function newUpdate(\System\Orm\DomainObject $obj) {
		$id = $obj->getId();

		$values['id_user'] = $obj->getUserId();
		$values['id_group'] = $obj->getMessageGroupId();


		if ($obj->getId() > -1) {
			return $this->buildStatement('update_visit', $values);
		}
		return $this->buildStatement('insert_visit', $values);
	}
}

?>