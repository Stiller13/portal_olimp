<?php

namespace Application\Orm;

class MessageIdentityObject extends \System\Orm\IdentityObject {

	function __construct($field=null){
		parent::__construct($field, array(
			'message_id',
			'user_id',
			'message_text',
			'message_date',
			'message_group',
			'message_user',
			'message_message',
			'message_status',
			'file_id',
			'id_message',
			'message_begin',
			'message_end'));
	}
}


?>