<?php

namespace Application\Orm;

class EUserIdentityObject extends \System\Orm\IdentityObject{
	function __construct($field=null) {
		parent::__construct($field, array(
			'user_id',
			'user_name',
			'user_surname',
			'user_patronymic',
			'user_date',
			'user_gender',
			'user_residence',
			'user_status',
			'user_mail',
			'user_telephone',
			'event_user_event',
			'event_user_user',
			'event_user_rule'));
	}
}
?>