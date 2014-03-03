<?php

namespace Application\Orm;

class UserFileUpdateFactory extends \System\Orm\UpdateFactory {

	public function newUpdate(\System\Orm\DomainObject $obj) {
		$values['id_user'] = $obj->getUser();
		$values['id_file'] = $obj->getFile();

		return $this->buildStatement('insert_user_file', $values);
	}
}

?>