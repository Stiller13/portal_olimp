<?php

namespace Application\Orm;

class EventUpdateFactory extends \System\Orm\UpdateFactory{

	function newUpdate(\System\Orm\DomainObject $obj) {
		$values["title"] = $obj->getTitle();
		$values["description_public"] = $obj->getDescription_public();
		$values["description_private"] = $obj->getDescription_private();
		$values["type"] = (\System\Helper\Helper::getId("type", $obj->getEvent_type()));
		$values["confirm"] = $obj->getConfirm();
		$values["confirm_description"] = $obj->getConfirm_description();

		$list_group = array();
		$list_group[] = $obj->getComments()->getId();
		foreach ($obj->getNoticeGroups() as $one_group) {
			$list_group[] = $one_group->getId();
		}
		$values['groups'] = implode(',', $list_group);

		$list_file = array();
		foreach ($obj->getFiles() as $one_file) {
			$list_file[] = $one_file->getId();
		}
		$values['files'] = implode(',', $list_file);

		if($obj->getId() > -1){
			$values["e_id"] = $obj->getId();
			return $this->buildStatement('update_event',$values);
		}

		return $this->buildStatement('insert_event',$values, 1);
	}
}

