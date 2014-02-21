<?php

namespace Application\Orm;

class EventUpdateFactory extends \System\Orm\UpdateFactory{

	function newUpdate(\System\Orm\DomainObject $obj) {
		$values["title"]=$obj->getTitle();
		$values["description_public"]=$obj->getDescription_public();
		$values["description_private"]=$obj->getDescription_private();
		$values["type"]=$obj->getEvent_type();
		$values["confirm"]=$obj->getConfirm();
		$values["confirm_description"]=$obj->getConfirm_description();

		if($obj->getId() > -1){
			$values["e_id"] = $obj->getId();
			return $this->buildStatement('update_event',$values);
		}

		return $this->buildStatement('insert_event',$values, 1);
	}
}

