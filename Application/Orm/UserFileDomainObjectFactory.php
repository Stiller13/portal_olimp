<?php

namespace Application\Orm;

class UserFileDomainObjectFactory extends \System\Orm\DomainObjectFactory {

	public function doCreateObject(array $array) {
		$obj= new \Application\Model\UserFile();

		$obj->setUser($array['user_file_user']);
		$obj->setFile($array['user_file_file']);

		return $obj;
	}

	public function targetClass() {
		return "UserFile";
	}
}

?>