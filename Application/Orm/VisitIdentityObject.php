<?php

namespace Application\Orm;

class VisitIdentityObject extends \System\Orm\IdentityObject {

	function __construct($field = null) {
		parent::__construct($field, array(
			'user_id',
			'group_id',
			'type',
			'datetime',
			'count_message'));
	}
}


?>