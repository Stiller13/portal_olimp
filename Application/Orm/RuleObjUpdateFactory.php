<?php

namespace Application\Orm;

class RuleObjUpdateFactory extends \System\Orm\UpdateFactory {

	public function newUpdate(\System\Orm\DomainObject $obj) {

		$values['id_user'] = $obj->getUser_id();
		$values['id_userset'] = $obj->getObj_id();
		$values['id_rule'] = $obj->getRule();

		return $this->buildStatement('insert_user_userset', $values);
	}
}

?>