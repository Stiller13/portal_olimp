<?php

namespace Application\Orm;

class FileUpdateFactory extends \System\Orm\UpdateFactory {

	public function newUpdate(\System\Orm\DomainObject $obj) {
		$values['file_name'] = $obj->getName();
		$values['file_code'] = $obj->getCode();
		$values['file_type'] = \System\Helper\Helper::getId("type", $obj->getFile_type());
		$values['file_status'] = \System\Helper\Helper::getId("status", $obj->getStatus());

		return $this->buildStatement('insert_file', $values, 1);
	}
}

?>