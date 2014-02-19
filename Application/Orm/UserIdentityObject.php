<?php

namespace Application\Orm;

class UserIdentityObject extends \System\Orm\IdentityObject{
	function __construct($field=null) {
		parent::__construct($field, array(
			'user_userset_user_id',
			'user_userset_userset_id',
			'user_id',
			'user_name',
			'user_surname',
			'user_patronymic',
			'user_date',
			'user_gender',
			'user_residence',
			'user_status',
			'user_mail',
			'user_telephone'));
	}
}
?>