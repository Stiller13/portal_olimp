<?php

namespace Application\Orm;

class FileUpdateFactory extends \System\Orm\UpdateFactory {

	public function newUpdate(\System\Orm\DomainObject $obj) {
		$values['file_name'] = $obj->getName();
		$values['file_code'] = $obj->getCode();

		return $this->buildStatement('insert_file', $values, 1);
	}
}

?>