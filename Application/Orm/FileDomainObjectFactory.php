<?php

namespace Application\Orm;

class FileDomainObjectFactory extends \System\Orm\DomainObjectFactory {

	public function doCreateObject(array $array) {
		$obj= new \Application\Model\File();

		$obj->setId($array['file_id']);
		$obj->setName($array['file_name']);
		$obj->setCode($array['file_code']);
		$obj->setDate($array['file_date']);
		$obj->setFile_type(\System\Helper\Helper::getName("type", $array['file_type']));
		$obj->setStatus(\System\Helper\Helper::getName("status", $array['file_status']));

		return $obj;
	}

	public function targetClass() {
		return "File";
	}
}

?>