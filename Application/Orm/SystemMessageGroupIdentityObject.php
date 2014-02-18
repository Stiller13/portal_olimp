<?php

namespace Application\Orm;

class SystemMessageGroupIdentityObject extends \System\Orm\IdentityObject {

	function __construct($field=null){
		parent::__construct($field, array(
			'messagegroup_id',
			'messagegroup_partners',
			'messagegroup_type',
			'messagegroup_status'));
	}
}


?>