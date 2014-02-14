<?php

namespace Application\Orm;

class VisitIdentityObject extends \System\Orm\IdentityObject {

	function __construct($field = null) {
		parent::__construct($field, array(
			'visit_id',
			'visit_user',
			'visit_group',
			'visit_datetime',
			'visit_count_message',
			'user_mg_read_user',
			'user_mg_read_mg'));
	}
}


?>