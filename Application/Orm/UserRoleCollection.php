<?php

namespace Application\Orm;


class UserRoleCollection extends \System\Orm\Collection{
	function targetClass(){
		return "UserRole";
	}
}
