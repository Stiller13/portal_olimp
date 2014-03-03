<?php

namespace Application\Orm;

class NoticeMessageGroupIdentityObject extends \System\Orm\IdentityObject {

	function __construct($field=null){
		parent::__construct($field, array(
			'messagegroup_id',
			'messagegroup_type',
			'messagegroup_status',
			'messagegroup_desc',
			'messagegroup_user_group',
			'messagegroup_user_user',
			'event_mg_event'));
	}
}

?>