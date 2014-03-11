<?php

namespace Application\Orm;

class PUserIdentityObject extends \System\Orm\IdentityObject{
	function __construct($field=null) {
		parent::__construct($field, array(
			'user_id',
			'psot_user_post',
			'post_user_user',
			'post_user_rule'));
	}
}
?>