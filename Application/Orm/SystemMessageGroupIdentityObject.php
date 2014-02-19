<?php

namespace Application\Orm;

class SystemMessageGroupIdentityObject extends \System\Orm\IdentityObject {

	function __construct($field=null){
		parent::__construct($field, array(
			'messagegroup_id',
			'messagegroup_partners',
			'messagegroup_type',
			'messagegroup_status',
			'messagegroup_desc',
			'user_userset_userset_id',
			'user_userset_user_id'));
	}
}


?>