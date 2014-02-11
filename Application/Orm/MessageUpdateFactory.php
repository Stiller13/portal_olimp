<?php

namespace Application\Orm;

class MessageUpdateFactory extends \System\Orm\UpdateFactory {

	public function newUpdate(\System\Orm\DomainObject $obj) {
		$values['message_text'] = $obj->getText();
		$values['message_author_id'] = $obj->getAuthor()->getId();
		$values['message_group_id'] = $obj->getGroup();

		$send_files = array();
		foreach ($obj->getFiles() as $one_file) {
			$send_files[] = $one_file->getId();
		}
		$values['message_files'] = implode(',', $send_files);

		return $this->buildStatement('insert_message', $values, 1);
	}
}

?>