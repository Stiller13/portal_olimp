<?php

namespace Application\Orm;

class MGUserCollection extends \System\Orm\Collection {
	function targetClass() {
		return "MGUser";
	}
}
?>