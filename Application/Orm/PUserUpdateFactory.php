<?php

namespace Application\Orm;

class PUserUpdateFactory extends \System\Orm\UpdateFactory{

	public function newUpdate(\System\Orm\DomainObject $obj) {
		$values['id_user'] = $obj->getId();
		$values['id_post'] = $obj->getPost();
		$values['id_rule'] = \System\Helper\Helper::getId("rule", $obj->getRule());
		$values['ratio'] = $obj->getRatio();

		return $this->buildStatement('insert_post_user', $values);
	}
}

?>
