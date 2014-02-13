<?php
namespace Application\Orm;

class RuleObjIdentityObject extends \System\Orm\IdentityObject{
	function __construct($field=null){
		parent::__construct($field, array(
			'user_id',
			'obj_id',
			'rule_id',
			'obj_type',
			'userset_id',
			'user_userset_user_id',
			'user_userset_userset_id',
			'user_userset_rule_id'));
	}
}

?>
