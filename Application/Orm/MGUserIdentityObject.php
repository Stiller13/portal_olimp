<?php

namespace Application\Orm;

class MGUserIdentityObject extends \System\Orm\IdentityObject{
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
			'messagegroup_user_group',
			'messagegroup_user_user'));
	}
}
?>