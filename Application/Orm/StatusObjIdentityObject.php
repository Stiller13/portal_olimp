<?php

namespace Application\Orm;

class StatusObjIdentityObject extends \System\Orm\IdentityObject{
	function __construct($field=null){
		parent::__construct($field, array(
			'obj_id',
			'obj_status',
			'obj_type')); 
	}
}


?>
