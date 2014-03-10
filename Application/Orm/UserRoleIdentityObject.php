<?php
namespace Application\Orm;

class UserRoleIdentityObject extends \System\Orm\IdentityObject {

	function __construct($field=null) {
		parent::__construct($field, array(
			'role_id',
			'role_user',
			'role_role')); 
	}
}


?>
