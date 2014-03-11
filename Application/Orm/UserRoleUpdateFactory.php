<?php

namespace Application\Orm;

class UserRoleUpdateFactory extends \System\Orm\UpdateFactory{

	public function newUpdate(\System\Orm\DomainObject $obj) {

		$values['id_user'] = $obj->getUser_id();
		$values['id_role'] = \System\Helper\Helper::getId("role", $obj->getRole());

		return $this->buildStatement('insert_role', $values, 1);
	}
}

?>
