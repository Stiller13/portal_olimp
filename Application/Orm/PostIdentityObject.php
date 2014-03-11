<?php

namespace Application\Orm;

class PostIdentityObject extends \System\Orm\IdentityObject{
	function __construct($field=null) {
		parent::__construct($field, array(
			'post_id',
			'post_status',
			'post_date',
			'post_type'));
	}
}
?>