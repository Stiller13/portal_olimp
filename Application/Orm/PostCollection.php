<?php

namespace Application\Orm;

class PostCollection extends \System\Orm\Collection {
	function targetClass() {
		return "Post";
	}
}
?>