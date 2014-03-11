<?php

namespace Application\Orm;

class EUserUpdateFactory extends \System\Orm\UpdateFactory{

	public function newUpdate(\System\Orm\DomainObject $obj) {
		$values['id_user'] = $obj->getId();
		$values['id_event'] = $obj->getEvent();
		$values['id_rule'] = \System\Helper\Helper::getId("rule", $obj->getRule());
		$values['id_file'] = $obj->getFile()->getId();

		return $this->buildStatement('insert_event_user', $values);
	}
}

?>
