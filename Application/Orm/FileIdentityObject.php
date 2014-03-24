<?php

namespace Application\Orm;

class FileIdentityObject extends \System\Orm\IdentityObject {

	function __construct($field = null) {
		parent::__construct($field, array(
			'file_id',
			'file_type',
			'file_code',
			'message_id',
			'messageset_id',
			'event_file_event',
			'user_file_user'));
	}
}


?>