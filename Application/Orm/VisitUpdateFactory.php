<?php

namespace Application\Orm;

class VisitUpdateFactory extends \System\Orm\UpdateFactory {

	public function newUpdate(\System\Orm\DomainObject $obj) {

		$values['id_user'] = $obj->getUserId();
		$values['id_group'] = $obj->getMessageGroupId();

		return $this->buildStatement('insert_visit', $values);
	}
}

?>