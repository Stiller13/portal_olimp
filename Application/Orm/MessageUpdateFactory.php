<?php

namespace Application\Orm;

class MessageUpdateFactory extends \System\Orm\UpdateFactory {

	public function newUpdate(\System\Orm\DomainObject $obj) {
		$values['text_message'] = $obj->getText();
		$values['id_user'] = $obj->getAuthor()->getId();
		$values['id_group'] = $obj->getGroup();
		$values['id_message'] = $obj->getReMessage();
		$values['status_message'] = \System\Helper\Helper::getId("status", $obj->getStatus());

		$send_files = array();
		foreach ($obj->getFiles() as $one_file) {
			$send_files[] = $one_file->getId();
		}
		$values['files'] = implode(',', $send_files);

		return $this->buildStatement('insert_message', $values, 1);
	}
}

?>