<?php

namespace Application\Orm;

class MGUserUpdateFactory extends \System\Orm\UpdateFactory {

	public function newUpdate(\System\Orm\DomainObject $obj) {
		$values['id_user'] = $obj->getId();
		$values['id_group'] = $obj->getGroup();

		if ($obj->getTimeUpdate()) {
			return $this->buildStatement('update_messagegroup_user', $values);
		}

		$values['id_rule'] = \System\Helper\Helper::getId("rule", $obj->getRule());

		return $this->buildStatement('insert_messagegroup_user', $values);
	}
}

?>
