<?php
namespace Application\Orm;

class AccountCollection extends \System\Orm\Collection{
	function targetClass(){
		return "Account";
	}
}

?>