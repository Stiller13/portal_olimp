<?php

namespace Application\Orm;

class PostUpdateFactory extends \System\Orm\UpdateFactory {

	public function newUpdate(\System\Orm\DomainObject $obj) {

		$values['id_post'] = $obj->getId();
		$values['title_post'] = $obj->getTitle();
		$values['text_post'] = $obj->getText();
		$values['id_mg'] = $obj->getComments()->getId();
		$values['status_post'] = \System\Helper\Helper::getId("status", $obj->getStatus());
		$values['type_post'] = \System\Helper\Helper::getId("type", $obj->getPost_type());

		return $this->buildStatement('insert_post', $values, 1);
	}
}

?>